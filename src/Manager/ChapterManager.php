<?php

namespace App\Manager;

use App\Api\MangaPlusApi;
use App\Entity\Chapter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;

readonly class ChapterManager
{
    public function __construct(
        private MangaPlusApi $mangaPlusApi,
        private EntityManagerInterface $entityManager,
        private string $chapterImagesPath,
    ) {}

    public function downloadChapter(Chapter $chapter): Chapter
    {
        $mangaViewer = $this->mangaPlusApi->getMangaViewer($chapter);

        if (!$mangaViewer) {
            return $chapter;
        }

        $filesystem = new Filesystem();

        $pages = [];
        foreach ($mangaViewer->getPages() as $index => $page) {
            $image = $this->mangaPlusApi->getPage($page);

            if (!$image) {
                continue;
            }

            $key = $page->getMangaPage()->getEncryptionKey();

            $binaryKey = pack('H*', $key);
            $keyLength = strlen($binaryKey);
            $imageLength = strlen($image);
            $extendedKey = str_repeat($binaryKey, (int) ceil($imageLength / $keyLength));

            $decrypted = $image ^ $extendedKey;

            $filename = sprintf(
                '%s/%s/%s/%s.jpg',
                $this->chapterImagesPath,
                $chapter->getManga()->getMangaPlusId(),
                $chapter->getMangaPlusId(),
                $index,
            );

            $pages[] = $filename;
            $filesystem->dumpFile($filename, $decrypted);
        }

        $cbzFilename = sprintf(
            '%s/%s/%s.cbz',
            $this->chapterImagesPath,
            $chapter->getManga()->getMangaPlusId(),
            $chapter->getMangaPlusId(),
        );

        $zip = new \ZipArchive();

        if (true !== $zip->open($cbzFilename, \ZipArchive::CREATE | \ZipArchive::OVERWRITE)) {
            throw new \Exception("Cannot create <{$cbzFilename}>");
        }

        foreach ($pages as $page) {
            if (file_exists($page)) {
                $zip->addFile($page, basename($page));
            }
        }

        $zip->close();

        $chapter->setDownloadUrl($cbzFilename);

        $this->entityManager->flush();

        return $chapter;
    }
}
