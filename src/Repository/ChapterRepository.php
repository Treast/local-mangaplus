<?php

namespace App\Repository;

use App\Entity\Chapter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Chapter>
 */
class ChapterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Chapter::class);
    }

    public function findOneByMangaPlusId(int $mangaPlusId): ?Chapter
    {
        return $this->findOneBy(['mangaPlusId' => $mangaPlusId]);
    }

    /**
     * @return array<Chapter>
     */
    public function findLatestDownloaded(): array
    {
        return $this
            ->createQueryBuilder('c')
            ->orderBy('c.downloadedAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return array<Chapter>
     */
    public function findPaginated(int $page, int $limit): array
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.downloadedAt', 'DESC')
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }

    public function countAll(): int
    {
        return $this->createQueryBuilder('c')
            ->select('COUNT(c.id)')
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }
}
