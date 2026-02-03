<?php

namespace App\Manager;

use App\Api\MangaPlusApi;
use App\Entity\Chapter;
use App\ImmutableValue\DownloadStatus;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;

readonly class ChapterManager
{
    public function __construct(
        private MangaPlusApi $mangaPlusApi,
        private EntityManagerInterface $entityManager,
        private NotificationManager $notificationManager,
        private string $chapterImagesPath,
    ) {}

    public function downloadChapter(Chapter $chapter): Chapter
    {
        $chapter->setDownloadStatus(DownloadStatus::Downloading);
        $this->entityManager->flush();

        $this->notificationManager->info(
            sprintf('Downloading chapter %s', $chapter->getSubTitle())
        );

        $mangaViewer = $this->mangaPlusApi->getMangaViewer($chapter);

        if (!$mangaViewer) {
            $chapter->setDownloadStatus(DownloadStatus::DownloadingFailed);
            $this->entityManager->flush();

            $this->notificationManager->error(
                sprintf('An error occured while downloading %s', $chapter->getSubTitle())
            );

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

        $chapter
            ->setDownloadStatus(DownloadStatus::Downloaded)
            ->setDownloadedAt(new \DateTimeImmutable())
            ->setCbzPath($cbzFilename)
        ;

        $this->entityManager->flush();

        $this->notificationManager->success(
            sprintf('Chapter %s downloaded successfully', $chapter->getSubTitle())
        );

        $this->notificationManager->sendDiscordMessage(
            sprintf(
                'Chapter %s %s downloaded successfully!',
                $chapter->getManga()->getTitle(),
                $chapter->getTitle(),
            ),
        );

        return $chapter;
    }

    /**
     * @return array<string>
     */
    public function extractChapterPages(Chapter $chapter): array
    {
        $zip = new \ZipArchive();
        $pages = [];

        if (true === $zip->open($chapter->getCbzPath())) {
            for ($i = 0; $i < $zip->numFiles; ++$i) {
                $name = $zip->getNameIndex($i);
                if (preg_match('/\.(jpg|jpeg|png|webp)$/i', $name)) {
                    $pages[] = $name;
                }
            }

            sort($pages);
            $zip->close();
        }

        return $pages;
    }

    public function extractChapterPage(Chapter $chapter, string $filename): false|string|null
    {
        $zip = new \ZipArchive();

        if (true === $zip->open($chapter->getCbzPath())) {
            $content = $zip->getFromName($filename);
            $zip->close();

            return $content;
        }

        return null;
    }
}
