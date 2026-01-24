<?php

namespace App\Entity;

use App\Entity\Trait\IdTrait;
use App\Entity\Trait\SyncableTrait;
use App\Entity\Trait\TimestampableTrait;
use App\ImmutableValue\Language;
use App\Repository\MangaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MangaRepository::class)]
#[ORM\Table(name: 'mangas')]
#[ORM\HasLifecycleCallbacks]
class Manga
{
    use IdTrait;
    use SyncableTrait;
    use TimestampableTrait;

    #[ORM\Column(type: Types::STRING)]
    private ?string $title = null;

    #[ORM\Column(type: Types::STRING)]
    private ?string $author = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => false])]
    private bool $simulReleased = false;

    #[ORM\Column(type: Types::INTEGER)]
    private ?int $mangaPlusId = null;

    #[ORM\Column(type: Types::STRING)]
    private ?string $portraitImageUrl = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $landscapeImageUrl = null;

    #[ORM\Column(type: Types::INTEGER)]
    private ?int $viewCount = null;

    #[ORM\Column(type: Types::ENUM, length: 2, enumType: Language::class)]
    private ?Language $language = null;

    #[ORM\ManyToOne(targetEntity: Serie::class, inversedBy: 'mangas')]
    private ?Serie $serie = null;

    #[ORM\OneToMany(targetEntity: Chapter::class, mappedBy: 'manga', cascade: ['persist'], orphanRemoval: false)]
    #[ORM\OrderBy(['releasedAt' => 'DESC'])]
    private Collection $chapters;

    public function __construct()
    {
        $this->chapters = new ArrayCollection();
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

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(?string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function isSimulReleased(): bool
    {
        return $this->simulReleased;
    }

    public function setSimulReleased(bool $simulReleased): self
    {
        $this->simulReleased = $simulReleased;

        return $this;
    }

    public function getMangaPlusId(): ?int
    {
        return $this->mangaPlusId;
    }

    public function setMangaPlusId(?int $mangaPlusId): self
    {
        $this->mangaPlusId = $mangaPlusId;

        return $this;
    }

    public function getPortraitImageUrl(): ?string
    {
        return $this->portraitImageUrl;
    }

    public function setPortraitImageUrl(?string $portraitImageUrl): self
    {
        $this->portraitImageUrl = $portraitImageUrl;

        return $this;
    }

    public function getLandscapeImageUrl(): ?string
    {
        return $this->landscapeImageUrl;
    }

    public function setLandscapeImageUrl(?string $landscapeImageUrl): self
    {
        $this->landscapeImageUrl = $landscapeImageUrl;

        return $this;
    }

    public function getViewCount(): ?int
    {
        return $this->viewCount;
    }

    public function setViewCount(?int $viewCount): self
    {
        $this->viewCount = $viewCount;

        return $this;
    }

    public function getLanguage(): ?Language
    {
        return $this->language;
    }

    public function setLanguage(?Language $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getSerie(): ?Serie
    {
        return $this->serie;
    }

    public function setSerie(?Serie $serie): self
    {
        $this->serie = $serie;

        return $this;
    }

    public function getChapters(): Collection
    {
        return $this->chapters;
    }

    public function addChapter(Chapter $chapter): self
    {
        if (!$this->chapters->contains($chapter)) {
            $this->chapters->add($chapter);
            $chapter->setManga($this);
        }

        return $this;
    }

    public function removeChapter(Chapter $chapter): self
    {
        if ($this->chapters->contains($chapter)) {
            $this->chapters->removeElement($chapter);
            $chapter->setManga(null);
        }

        return $this;
    }

    public function setChapters(Collection $chapters): self
    {
        $this->chapters = $chapters;

        return $this;
    }

    public function cleanChapters(): self
    {
        foreach ($this->chapters as $chapter) {
            $this->removeChapter($chapter);
        }

        return $this;
    }
}
