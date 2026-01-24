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

    /**
     * @return array<Serie>
     */
    public function search(string $query): array
    {
        return $this->createQueryBuilder('s')
            ->where('s.title LIKE :query')
            ->setParameter('query', "%{$query}%")
            ->setMaxResults(12)
            ->getQuery()
            ->getResult()
        ;
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
