<?php

namespace App\Manager;

use App\Api\MangaPlusApi;
use Doctrine\ORM\EntityManagerInterface;

readonly class SyncManager
{
    public function __construct(
        private MangaPlusApi $mangaPlusApi,
        private ConfigurationManager $configurationManager,
        private EntityManagerInterface $entityManager,
    ) {}

    public function sync(): void
    {
        $this->mangaPlusApi->getTitlesV3();

        $this->configurationManager->set('last_sync', new \DateTime());
        $this->entityManager->flush();
    }
}
