<?php

namespace App\MessageHandler;

use App\Api\MangaPlusApi;
use App\ImmutableValue\DownloadStatus;
use App\Message\DownloadChapterMessage;
use App\Message\SyncLibraryMangaMessage;
use App\Repository\MangaRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
final readonly class SyncLibraryMangaMessageHandler
{
    public function __construct(
        private MangaRepository $mangaRepository,
        private MangaPlusApi $mangaPlusApi,
        private MessageBusInterface $messageBus,
    ) {}

    public function __invoke(SyncLibraryMangaMessage $message): void
    {
        $mangaInLibrary = $this->mangaRepository->findAllInLibrary();

        $chaptersToDownload = [];
        foreach ($mangaInLibrary as $manga) {
            $updatedManga = $this->mangaPlusApi->getTitleDetailV3($manga);

            foreach ($updatedManga->getChapters() as $chapter) {
                if (DownloadStatus::NotDownloaded === $chapter->getDownloadStatus()) {
                    $chaptersToDownload[] = $chapter;
                }
            }
        }

        foreach ($chaptersToDownload as $chapter) {
            $this->messageBus->dispatch(new DownloadChapterMessage($chapter->getId()));
        }
    }
}
