<?php

namespace App\Message;

use Symfony\Component\Messenger\Attribute\AsMessage;

#[AsMessage]
final readonly class DownloadChapterMessage
{
    public function __construct(
        public int $chapterId
    ) {}

    public function getChapterId(): int
    {
        return $this->chapterId;
    }
}
