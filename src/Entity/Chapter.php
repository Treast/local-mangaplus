<?php

namespace App\Entity;

use App\Entity\Trait\IdTrait;
use App\Entity\Trait\TimestampableTrait;
use App\Repository\ChapterRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChapterRepository::class)]
#[ORM\Table(name: 'chapters')]
#[ORM\HasLifecycleCallbacks]
class Chapter
{
    use IdTrait;
    use TimestampableTrait;

    #[ORM\Column(type: Types::STRING)]
    private ?string $title = null;

    #[ORM\Column(type: Types::STRING)]
    private ?string $subTitle = null;

    #[ORM\Column(type: Types::INTEGER)]
    private ?int $mangaPlusId = null;

    #[ORM\ManyToOne(targetEntity: Manga::class, inversedBy: 'chapters')]
    private ?Manga $manga = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $downloadUrl = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $releasedAt = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $readableUntil = null;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSubTitle(): ?string
    {
        return $this->subTitle;
    }

    public function setSubTitle(?string $subTitle): self
    {
        $this->subTitle = $subTitle;

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

    public function getManga(): ?Manga
    {
        return $this->manga;
    }

    public function setManga(?Manga $manga): self
    {
        $this->manga = $manga;

        return $this;
    }

    public function getDownloadUrl(): ?string
    {
        return $this->downloadUrl;
    }

    public function setDownloadUrl(?string $downloadUrl): self
    {
        $this->downloadUrl = $downloadUrl;

        return $this;
    }

    public function getReleasedAt(): ?\DateTimeImmutable
    {
        return $this->releasedAt;
    }

    public function setReleasedAt(?\DateTimeImmutable $releasedAt): self
    {
        $this->releasedAt = $releasedAt;

        return $this;
    }

    public function getReadableUntil(): ?\DateTimeImmutable
    {
        return $this->readableUntil;
    }

    public function setReadableUntil(?\DateTimeImmutable $readableUntil): self
    {
        $this->readableUntil = $readableUntil;

        return $this;
    }
}
