<?php

namespace App\Entity;

use App\Entity\Trait\IdTrait;
use App\ImmutableValue\Language;
use App\Repository\MangaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MangaRepository::class)]
#[ORM\Table(name: 'mangas')]
class Manga
{
    use IdTrait;

    #[ORM\Column(type: Types::STRING)]
    private ?string $title = null;

    #[ORM\Column(type: Types::STRING)]
    private ?string $author = null;

    #[ORM\Column(type: Types::STRING)]
    private ?int $mangaPlusId = null;

    #[ORM\Column(type: Types::STRING)]
    private ?string $portraitImageUrl = null;

    #[ORM\Column(type: Types::STRING)]
    private ?string $landscapeImageUrl = null;

    #[ORM\Column(type: Types::INTEGER)]
    private ?int $viewCount = null;

    #[ORM\Column(type: Types::ENUM, length: 2, enumType: Language::class)]
    private ?Language $language = null;

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
}
