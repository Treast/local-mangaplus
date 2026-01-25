<?php

namespace App\MessageHandler;

use App\Manager\ChapterManager;
use App\Message\DownloadChapterMessage;
use App\Repository\ChapterRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(fromTransport: 'async')]
readonly class DownloadChapterHandler
{
    public function __construct(
        private ChapterManager $chapterManager,
        private ChapterRepository $chapterRepository,
    ) {}

    public function __invoke(DownloadChapterMessage $message): void
    {
        $chapter = $this->chapterRepository->find($message->chapterId);

        if (!$chapter) {
            return;
        }

        $this->chapterManager->downloadChapter($chapter);
    }
}
