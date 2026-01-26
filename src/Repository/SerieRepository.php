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

    /**
     * @param array<string> $genres
     *
     * @return array<Serie>
     */
    public function findPaginated(int $page, int $limit, array $genres): array
    {
        $query = $this->createQueryBuilder('s');

        if (count($genres) > 0) {
            $query
                ->leftJoin('s.genres', 'g')
                ->where('g.slug IN (:genres)')
                ->setParameter('genres', $genres)
            ;
        }

        return $query
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param array<string> $genres
     */
    public function countAll(array $genres): int
    {
        $query = $this->createQueryBuilder('s')
            ->select('COUNT(s.id)')
        ;

        if (count($genres) > 0) {
            $query
                ->leftJoin('s.genres', 'g')
                ->where('g.slug IN (:genres)')
                ->setParameter('genres', $genres)
            ;
        }

        return $query
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }
}
