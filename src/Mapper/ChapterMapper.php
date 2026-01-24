<?php

namespace App\Mapper;

use App\Api\Protobuf\MangaPlus\Chapter as MangaPlusChapter;
use App\Entity\Chapter;
use App\Repository\ChapterRepository;
use Doctrine\ORM\EntityManagerInterface;

readonly class ChapterMapper
{
    public function __construct(
        private ChapterRepository $chapterRepository,
        private EntityManagerInterface $entityManager,
    ) {}

    public function toChapter(MangaPlusChapter $mangaPlusChapter): Chapter
    {
        if ($chapter = $this->chapterRepository->findOneByMangaPlusId($mangaPlusChapter->getChapterId())) {
            return $chapter;
        }

        $releasedAt = new \DateTimeImmutable()->setTimestamp($mangaPlusChapter->getStartTimeStamp());
        $readableUntil = new \DateTimeImmutable()->setTimestamp($mangaPlusChapter->getEndTimeStamp());

        $chapter = new Chapter()
            ->setTitle($mangaPlusChapter->getName())
            ->setSubTitle($mangaPlusChapter->getSubTitle())
            ->setMangaPlusId($mangaPlusChapter->getChapterId())
            ->setReleasedAt($releasedAt)
            ->setReadableUntil($readableUntil)
        ;

        $this->entityManager->persist($chapter);
        $this->entityManager->flush();

        return $chapter;
    }
}
