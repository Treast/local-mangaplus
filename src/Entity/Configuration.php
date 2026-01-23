<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'configuration')]
class Configuration
{
    #[ORM\Id]
    #[ORM\Column(type: Types::STRING)]
    private ?string $key = null;

    #[ORM\Column(type: Types::JSON)]
    private mixed $value = null;

    public function getKey(): ?string
    {
        return $this->key;
    }

    public function setKey(?string $key): self
    {
        $this->key = $key;

        return $this;
    }

    public function getValue(): mixed
    {
        if (is_array($this->value) && isset($this->value['type'])) {
            if ('datetime' === $this->value['type']) {
                return new \DateTime($this->value['data']);
            }

            return $this->value['data'];
        }

        return $this->value;
    }

    public function setValue(mixed $value): self
    {
        if ($value instanceof \DateTimeInterface) {
            $this->value = [
                'type' => 'datetime',
                'data' => $value->format(\DateTimeInterface::ATOM),
            ];
        } else {
            $this->value = [
                'type' => 'scalar',
                'data' => $value,
            ];
        }

        return $this;
    }
}
