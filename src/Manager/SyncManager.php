<?php

namespace App\Manager;

use App\Api\MangaPlusApi;
use App\Message\SyncSeriesMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

readonly class SyncManager
{
    public function __construct(
        private MessageBusInterface $bus,
        private MangaPlusApi $mangaPlusApi,
        private ConfigurationManager $configurationManager,
        private EntityManagerInterface $entityManager,
    ) {}

    public function sync(): void
    {
        $this->bus->dispatch(new SyncSeriesMessage());
    }

    public function loadMangas(): void
    {
        $this->mangaPlusApi->getTitlesV3();

        $this->configurationManager->set('last_sync', new \DateTime());
        $this->entityManager->flush();
    }
}
