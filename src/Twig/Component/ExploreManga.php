<?php

namespace App\Twig\Component;

use App\Entity\Genre;
use App\Entity\Serie;
use App\Repository\GenreRepository;
use App\Repository\SerieRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('ExploreManga', 'components/ExploreManga.html.twig')]
final class ExploreManga
{
    use DefaultActionTrait;

    private const int ITEMS_PER_PAGE = 24;

    #[LiveProp(writable: true, url: true)]
    public int $page = 1;

    /**
     * @var array<string>
     */
    #[LiveProp(url: true)]
    public array $genres = [];

    public function __construct(
        private readonly SerieRepository $serieRepository,
        private readonly GenreRepository $genreRepository,
    ) {}

    /**
     * @return array<Genre>
     */
    public function getAllGenres(): array
    {
        return $this->genreRepository->findAll();
    }

    #[LiveAction]
    public function selectGenre(#[LiveArg] string $slug): void
    {
        if (in_array($slug, $this->genres)) {
            $this->genres = array_diff($this->genres, [$slug]);
        } else {
            $this->genres[] = $slug;
        }
    }

    /**
     * @return array<Serie>
     */
    public function getSeries(): array
    {
        return $this->serieRepository->findPaginated($this->page, self::ITEMS_PER_PAGE, $this->genres);
    }

    public function getTotalPages(): int
    {
        return (int) ceil($this->serieRepository->countAll($this->genres) / self::ITEMS_PER_PAGE);
    }
}
