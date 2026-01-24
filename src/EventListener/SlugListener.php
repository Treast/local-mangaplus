<?php

namespace App\EventListener;

use App\Entity\Genre;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Symfony\Component\String\Slugger\AsciiSlugger;

#[AsEntityListener(event: Events::prePersist, method: 'prePersist', entity: Genre::class)]
#[AsEntityListener(event: Events::preUpdate, method: 'preUpdate', entity: Genre::class)]
class SlugListener
{
    public function prePersist(Genre $genre): void
    {
        $genre->setSlug($this->slugify($genre->getName()));
    }

    public function preUpdate(Genre $genre): void
    {
        $genre->setSlug($this->slugify($genre->getName()));
    }

    private function slugify(string $text): string
    {
        $slugger = new AsciiSlugger();

        return $slugger->slug($text)->lower()->toString();
    }
}
