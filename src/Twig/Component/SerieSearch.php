<?php

namespace App\Twig\Component;

use App\Entity\Serie;
use App\Repository\SerieRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('SerieSearch', template: 'components/SerieSearch.html.twig')]
final class SerieSearch
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public string $query = '';

    public function __construct(
        private readonly SerieRepository $serieRepository
    ) {}

    /**
     * @return array<Serie>
     */
    public function getSeries(): array
    {
        return $this->serieRepository->search($this->query);
    }
}
