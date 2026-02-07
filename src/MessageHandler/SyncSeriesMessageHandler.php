<?php

namespace App\MessageHandler;

use App\Manager\NotificationManager;
use App\Manager\SyncManager;
use App\Message\SyncSeriesMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class SyncSeriesMessageHandler
{
    public function __construct(
        private NotificationManager $notificationManager,
        private SyncManager $syncManager,
    ) {}

    public function __invoke(SyncSeriesMessage $message): void
    {
        $this->notificationManager->info('Syncing series...');

        $this->syncManager->loadMangas();

        $this->notificationManager->success('Sync completed!');
    }
}
