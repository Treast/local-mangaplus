<?php

namespace App\Mapper;

use App\Api\Protobuf\MangaPlus\Title;
use App\Entity\Manga;
use App\ImmutableValue\Language;
use App\Repository\MangaRepository;
use Doctrine\ORM\EntityManagerInterface;

readonly class TitleMapper
{
    public function __construct(
        private MangaRepository $mangaRepository,
        private EntityManagerInterface $entityManager,
    ) {}

    public function toManga(Title $title): Manga
    {
        if ($manga = $this->mangaRepository->findOneByMangaPlusId($title->getTitleId())) {
            return $manga;
        }

        $manga = new Manga()
            ->setTitle($title->getName())
            ->setAuthor($title->getAuthor())
            ->setMangaPlusId($title->getTitleId())
            ->setPortraitImageUrl($title->getPortraitImageUrl())
            ->setLandscapeImageUrl($title->getLandscapeImageUrl())
            ->setViewCount($title->getViewCount())
            ->setLanguage(Language::fromLanguageId($title->getLanguage()))
        ;

        $this->entityManager->persist($manga);
        $this->entityManager->flush();

        return $manga;
    }
}
