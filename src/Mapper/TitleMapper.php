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
        if (!$manga = $this->mangaRepository->findOneByMangaPlusId($title->getTitleId())) {
            $manga = new Manga();
        }

        $manga
            ->setTitle($title->getName())
            ->setAuthor($title->getAuthor())
            ->setMangaPlusId($title->getTitleId())
            ->setPortraitImageUrl($title->getPortraitImageUrl())
            ->setLandscapeImageUrl($title->getLandscapeImageUrl())
            ->setViewCount($title->getViewCount())
            ->setLanguage(Language::fromLanguageId($title->getLanguage()))
            ->setSynchedAt(new \DateTimeImmutable())
        ;

        dump($manga);

        if (!$this->entityManager->contains($manga)) {
            $this->entityManager->persist($manga);
        }

        $this->entityManager->flush();

        return $manga;
    }
}
