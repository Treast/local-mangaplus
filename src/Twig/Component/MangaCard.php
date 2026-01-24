<?php

namespace App\Twig\Component;

use App\Entity\Manga;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('MangaCard', 'components/MangaCard.html.twig')]
final class MangaCard
{
    public ?Manga $manga = null;
}
