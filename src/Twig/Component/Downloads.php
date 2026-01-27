<?php

namespace App\Twig\Component;

use App\Entity\Chapter;
use App\Repository\ChapterRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('Downloads', 'components/Downloads.html.twig')]
final class Downloads
{
    use DefaultActionTrait;

    private const int ITEMS_PER_PAGE = 20;

    #[LiveProp(writable: true, url: true)]
    public int $page = 1;

    public function __construct(
        private readonly ChapterRepository $chapterRepository,
    ) {}

    /**
     * @return array<Chapter>
     */
    public function getChapters(): array
    {
        return $this->chapterRepository->findPaginated($this->page, self::ITEMS_PER_PAGE);
    }

    public function getTotalPages(): int
    {
        return (int) ceil($this->chapterRepository->countAll() / self::ITEMS_PER_PAGE);
    }
}
