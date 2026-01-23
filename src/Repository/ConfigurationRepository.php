<?php

namespace App\Repository;

use App\Entity\Configuration;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Configuration>
 */
class ConfigurationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Configuration::class);
    }

    public function get(string $key): ?Configuration
    {
        return $this->findOneBy(['key' => $key]);
    }

    public function getValue(string $key, mixed $default = null): mixed
    {
        $config = $this->findOneBy(['key' => $key]);

        return $config ? $config->getValue() : $default;
    }
}
