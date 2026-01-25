<?php

namespace App\Twig\Component;

use App\Entity\Manga;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('AddToLibraryButton', template: 'components/AddToLibraryButton.html.twig')]
final class AddToLibraryButton
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public Manga $manga;

    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {}

    #[LiveAction]
    public function toggleIsInLibrary(): void
    {
        $this->manga->setIsInLibrary(!$this->manga->getIsInLibrary());

        $this->entityManager->flush();
    }
}
