<?php

namespace App\Mapper;

use App\Api\Protobuf\MangaPlus\ChapterGroup;
use App\Api\Protobuf\MangaPlus\TitleDetailView;
use App\Entity\Manga;
use Doctrine\ORM\EntityManagerInterface;

readonly class TitleDetailViewMapper
{
    public function __construct(
        private ChapterMapper $chapterMapper,
        private EntityManagerInterface $entityManager,
    ) {}

    public function updateManga(Manga $manga, TitleDetailView $titleDetailView): Manga
    {
        $manga
            ->setDescription($titleDetailView->getOverview())
            ->setViewCount($titleDetailView->getNumberOfViews())
            ->setSimulReleased($titleDetailView->getIsSimulReleased())
            ->setSynchedAt(new \DateTimeImmutable())
            ->cleanChapters()
        ;

        /** @var ChapterGroup $chapterGroups */
        foreach ($titleDetailView->getChapterListGroup() as $chapterGroups) {
            $chapters = [
                ...iterator_to_array($chapterGroups->getFirstChapterList()),
                ...iterator_to_array($chapterGroups->getMidChapterList()),
                ...iterator_to_array($chapterGroups->getLastChapterList()),
            ];

            foreach ($chapters as $chapter) {
                $manga->addChapter($this->chapterMapper->toChapter($chapter));
            }
        }

        $this->entityManager->flush();

        return $manga;
    }
}
