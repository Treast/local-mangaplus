<?php

namespace App\Entity;

use App\Entity\Trait\IdTrait;
use App\Entity\Trait\TimestampableTrait;
use App\ImmutableValue\Language;
use App\Repository\SerieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SerieRepository::class)]
#[ORM\Table(name: 'series')]
#[ORM\HasLifecycleCallbacks]
class Serie
{
    use IdTrait;
    use TimestampableTrait;

    #[ORM\Column(type: Types::STRING)]
    private ?string $title = null;

    #[ORM\Column(type: Types::STRING)]
    private ?string $imageUrl = null;

    /**
     * @var Collection<int, Manga>
     */
    #[ORM\OneToMany(targetEntity: Manga::class, mappedBy: 'serie', cascade: ['persist'], orphanRemoval: false)]
    private Collection $mangas;

    /**
     * @var Collection<int, Genre>
     */
    #[ORM\JoinTable(name: 'series_genres')]
    #[ORM\ManyToMany(targetEntity: Genre::class, inversedBy: 'series', cascade: ['persist'])]
    private Collection $genres;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $lastUpdatedAt = null;

    public function __construct()
    {
        $this->mangas = new ArrayCollection();
        $this->genres = new ArrayCollection();
    }

    public function getFirstPortraitImageUrl(): ?string
    {
        $englishManga = $this->mangas->findFirst(fn (int $key, Manga $manga) => Language::English === $manga->getLanguage());

        if ($englishManga?->getPortraitImageUrl()) {
            return $englishManga->getPortraitImageUrl();
        }

        $frenchManga = $this->mangas->findFirst(fn (int $key, Manga $manga) => Language::French === $manga->getLanguage());

        if ($frenchManga?->getPortraitImageUrl()) {
            return $frenchManga->getPortraitImageUrl();
        }

        if ($manga = $this->mangas->first()) {
            return $manga->getPortraitImageUrl();
        }

        return null;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(?string $imageUrl): self
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    /**
     * @return Collection<int, Manga>
     */
    public function getMangas(): Collection
    {
        return $this->mangas;
    }

    public function addManga(Manga $manga): self
    {
        if (!$this->mangas->contains($manga)) {
            $this->mangas->add($manga);
            $manga->setSerie($this);
        }

        return $this;
    }

    public function removeManga(Manga $manga): self
    {
        if ($this->mangas->contains($manga)) {
            $this->mangas->removeElement($manga);

            $manga->setSerie(null);
        }

        return $this;
    }

    /**
     * @param Collection<int, Manga> $mangas
     */
    public function setMangas(Collection $mangas): self
    {
        $this->mangas = $mangas;

        return $this;
    }

    public function cleanMangas(): self
    {
        foreach ($this->mangas as $manga) {
            $this->removeManga($manga);
        }

        return $this;
    }

    /**
     * @return Collection<int, Genre>
     */
    public function getGenres(): Collection
    {
        return $this->genres;
    }

    public function addGenre(Genre $genre): self
    {
        if (!$this->genres->contains($genre)) {
            $this->genres->add($genre);

            $genre->addSerie($this);
        }

        return $this;
    }

    public function removeGenre(Genre $genre): self
    {
        if ($this->genres->contains($genre)) {
            $this->genres->removeElement($genre);

            $genre->removeSerie($this);
        }

        return $this;
    }

    /**
     * @param Collection<int, Genre> $genres
     */
    public function setGenres(Collection $genres): self
    {
        $this->genres = $genres;

        return $this;
    }

    public function cleanGenres(): self
    {
        foreach ($this->genres as $genre) {
            $this->removeGenre($genre);
        }

        return $this;
    }

    public function getLastUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->lastUpdatedAt;
    }

    public function setLastUpdatedAt(?\DateTimeImmutable $lastUpdatedAt): self
    {
        $this->lastUpdatedAt = $lastUpdatedAt;

        return $this;
    }
}
