<?php

namespace App\Mapper;

use App\Api\Protobuf\MangaPlus\Category;
use App\Entity\Genre;
use App\Repository\GenreRepository;
use Doctrine\ORM\EntityManagerInterface;

readonly class CategoryMapper
{
    public function __construct(
        private GenreRepository $genreRepository,
        private EntityManagerInterface $entityManager
    ) {}

    public function toGenre(Category $category): Genre
    {
        if ($genre = $this->genreRepository->findOneByName($category->getLabel())) {
            return $genre;
        }

        $genre = new Genre()
            ->setName($category->getLabel())
        ;

        $this->entityManager->persist($genre);
        $this->entityManager->flush();

        return $genre;
    }
}
