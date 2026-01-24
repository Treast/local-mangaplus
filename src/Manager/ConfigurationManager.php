<?php

namespace App\Manager;

use App\Entity\Configuration;
use App\Repository\ConfigurationRepository;
use Doctrine\ORM\EntityManagerInterface;

readonly class ConfigurationManager
{
    public function __construct(
        private ConfigurationRepository $configurationRepository,
        private EntityManagerInterface $entityManager
    ) {}

    public function get(string $key): ?Configuration
    {
        return $this->configurationRepository->get($key);
    }

    public function getValue(string $key): mixed
    {
        return $this->configurationRepository->getValue($key);
    }

    public function set(string $key, mixed $value): void
    {
        if (!$configuration = $this->configurationRepository->get($key)) {
            $configuration = new Configuration()->setKey($key);

            $this->entityManager->persist($configuration);
        }

        $configuration->setValue($value);

        $this->entityManager->flush();
    }
}
