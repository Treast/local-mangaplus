<?php

namespace App\Twig\Component;

use App\Entity\Serie;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('SerieCard', 'components/SerieCard.html.twig')]
final class SerieCard
{
    public ?Serie $serie = null;
}
