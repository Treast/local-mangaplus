<?php

namespace App\Mapper;

use App\Api\Protobuf\MangaPlus\Title;
use App\Entity\Manga;
use App\ImmutableValue\Language;
use App\Repository\MangaRepository;

readonly class TitleMapper
{
    public function __construct(
        private MangaRepository $mangaRepository,
    ) {}

    public function toManga(Title $title): Manga
    {
        if ($manga = $this->mangaRepository->findOneByMangaPlusId($title->getTitleId())) {
            return $manga;
        }

        return new Manga()
            ->setTitle($title->getName())
            ->setAuthor($title->getAuthor())
            ->setMangaPlusId($title->getTitleId())
            ->setPortraitImageUrl($title->getPortraitImageUrl())
            ->setLandscapeImageUrl($title->getLandscapeImageUrl())
            ->setViewCount($title->getViewCount())
            ->setLanguage(Language::fromLanguageId($title->getLanguage()))
        ;
    }
}
