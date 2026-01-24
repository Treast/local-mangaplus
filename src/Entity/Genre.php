<?php

namespace App\Entity;

use App\Entity\Trait\IdTrait;
use App\Repository\GenreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GenreRepository::class)]
#[ORM\Table(name: 'genres')]
final class Genre
{
    use IdTrait;

    #[ORM\Column(type: Types::STRING)]
    private ?string $name = null;

    #[ORM\Column(type: Types::STRING, unique: true)]
    private ?string $slug = null;

    /**
     * @var Collection<int, Serie>
     */
    #[ORM\ManyToMany(targetEntity: Serie::class, mappedBy: 'genres', cascade: ['persist'])]
    private Collection $series;

    public function __construct()
    {
        $this->series = new ArrayCollection();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = trim($name);

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection<int, Serie>
     */
    public function getSeries(): Collection
    {
        return $this->series;
    }

    public function addSerie(Serie $serie): self
    {
        if (!$this->series->contains($serie)) {
            $this->series[] = $serie;
        }

        return $this;
    }

    public function removeSerie(Serie $serie): self
    {
        if ($this->series->contains($serie)) {
            $this->series->removeElement($serie);
        }

        return $this;
    }

    /**
     * @param Collection<int, Serie> $series
     */
    public function setSeries(Collection $series): self
    {
        $this->series = $series;

        return $this;
    }
}
