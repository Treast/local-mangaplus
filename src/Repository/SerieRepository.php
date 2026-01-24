<?php

namespace App\Repository;

use App\Entity\Serie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Serie>
 */
class SerieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Serie::class);
    }

    public function findOneByTitle(string $title): ?Serie
    {
        return $this->findOneBy(['title' => $title]);
    }

    /**
     * @return array<Serie>
     */
    public function getLatestUpdated(): array
    {
        return $this->findBy([], ['lastUpdatedAt' => 'DESC'], 12);
    }
}
