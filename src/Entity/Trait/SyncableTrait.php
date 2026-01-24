<?php

namespace App\Entity\Trait;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait SyncableTrait
{
    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $synchedAt = null;

    public function getSynchedAt(): ?\DateTimeImmutable
    {
        return $this->synchedAt;
    }

    public function setSynchedAt(?\DateTimeImmutable $synchedAt): self
    {
        $this->synchedAt = $synchedAt;

        return $this;
    }

    public function shouldSync(): bool
    {
        if (!$this->synchedAt) {
            return true;
        }

        return (clone $this->synchedAt)->modify('+2 hours') < new \DateTimeImmutable('now');
    }
}
