<?php

namespace App\MessageHandler;

use App\Api\MangaPlusApi;
use App\Manager\ConfigurationManager;
use App\Manager\NotificationManager;
use App\Message\SyncSeriesMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class SyncSeriesMessageHandler
{
    public function __construct(
        private MangaPlusApi $mangaPlusApi,
        private ConfigurationManager $configurationManager,
        private EntityManagerInterface $entityManager,
        private NotificationManager $notificationManager,
    ) {}

    public function __invoke(SyncSeriesMessage $message): void
    {
        $this->notificationManager->info('Syncing series...');

        $this->mangaPlusApi->getTitlesV3();

        $this->configurationManager->set('last_sync', new \DateTime());
        $this->entityManager->flush();

        $this->notificationManager->success('Sync completed!');
    }
}
