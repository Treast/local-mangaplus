<?php

namespace App\Twig\Component\Chapter;

use App\Entity\Chapter;
use App\ImmutableValue\DownloadStatus;
use App\Message\DownloadChapterMessage;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('Chapter:DownloadButton', template: 'components/Chapter/DownloadButton.html.twig')]
final class DownloadButton
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public Chapter $chapter;

    public function __construct(
        private readonly MessageBusInterface $messageBus,
    ) {}

    #[LiveAction]
    public function onChapterUpdate(): void {}

    #[LiveAction]
    public function startDownload(): void
    {
        $this->chapter->setDownloadStatus(DownloadStatus::Downloading);

        $this->messageBus->dispatch(new DownloadChapterMessage($this->chapter->getId()));
    }
}
