<?php

namespace App\Entity;

use App\Repository\SearchRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SearchRepository::class)]
class Search
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $type = [];

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $rarity = [];

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $series = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): array
    {
        return $this->type;
    }

    public function setType(?array $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getRarity(): array
    {
        return $this->rarity;
    }

    public function setRarity(?array $rarity): self
    {
        $this->rarity = $rarity;

        return $this;
    }

    public function getSeries(): array
    {
        return $this->series;
    }

    public function setSeries(?array $series): self
    {
        $this->series = $series;

        return $this;
    }
}
