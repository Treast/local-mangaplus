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
        $mangas = $this->mangaPlusApi->getTitlesV2();

        foreach ($mangas as $manga) {
            if (!$this->entityManager->contains($manga)) {
                $this->entityManager->persist($manga);
            }
        }

        $this->configurationManager->set('last_sync', new \DateTime());
        $this->entityManager->flush();
    }
}
