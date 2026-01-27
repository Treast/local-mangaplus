<?php

namespace App\Mapper;

use App\Api\Protobuf\MangaPlus\TitleContainer;
use App\Entity\Serie;
use App\Repository\SerieRepository;
use Doctrine\ORM\EntityManagerInterface;

readonly class TitleContainerMapper
{
    public function __construct(
        private CategoryMapper $categoryMapper,
        private TitleMapper $titleMapper,
        private SerieRepository $serieRepository,
        private EntityManagerInterface $entityManager,
    ) {}

    public function toSerie(TitleContainer $titleContainer): Serie
    {
        if (!$serie = $this->serieRepository->findOneByTitle($titleContainer->getMainName())) {
            $serie = new Serie()
                ->setTitle($titleContainer->getMainName())
            ;
        }

        $serie
            ->cleanGenres()
            ->cleanMangas()
        ;

        foreach ($titleContainer->getCategories() as $category) {
            $serie->addGenre($this->categoryMapper->toGenre($category));
        }

        foreach ($titleContainer->getMultiLangTitles() as $title) {
            $serie->addManga($this->titleMapper->toManga($title));
        }

        if (!$serie->getImageUrl()) {
            $serie->setImageUrl($serie->getFirstPortraitImageUrl());
        }

        $lastUpdatedAt = new \DateTimeImmutable()->setTimestamp($titleContainer->getTimestamp());
        $serie
            ->setLastUpdatedAt($lastUpdatedAt)
            ->setSynchedAt(new \DateTimeImmutable())
        ;

        if (!$this->entityManager->contains($serie)) {
            $this->entityManager->persist($serie);
        }

        $this->entityManager->flush();

        return $serie;
    }
}
