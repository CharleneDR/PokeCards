<?php

namespace App\Entity;

use App\Repository\CardRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CardRepository::class)]
class Card
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $apiId = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $imageLarge = null;

    #[ORM\Column(length: 255)]
    private ?string $imageSmall = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $type = [];

    #[ORM\Column(length: 255)]
    private ?string $supertype = null;

    #[ORM\Column(length: 255)]
    private ?string $series = null;

    #[ORM\Column(length: 255)]
    private ?string $number = null;

    #[ORM\Column]
    private ?int $totalSet = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $rarity = null;

    #[ORM\Column]
    private ?int $printedTotal = null;

    #[ORM\Column(nullable: true)]
    private ?int $trendPrice = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $artist = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $evolvesTo = null;

    #[ORM\ManyToMany(targetEntity: Search::class, mappedBy: 'cards')]
    private Collection $searches;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'collection')]
    private Collection $collectors;

    public function __construct()
    {
        $this->searches = new ArrayCollection();
        $this->collectors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getApiId(): ?string
    {
        return $this->apiId;
    }

    public function setApiId(string $apiId): self
    {
        $this->apiId = $apiId;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getImageLarge(): ?string
    {
        return $this->imageLarge;
    }

    public function setImageLarge(string $imageLarge): self
    {
        $this->imageLarge = $imageLarge;

        return $this;
    }

    public function getImageSmall(): ?string
    {
        return $this->imageSmall;
    }

    public function setImageSmall(string $imageSmall): self
    {
        $this->imageSmall = $imageSmall;

        return $this;
    }

    public function getType(): array
    {
        return $this->type;
    }

    public function setType(array $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getSupertype(): ?string
    {
        return $this->supertype;
    }

    public function setSupertype(string $supertype): self
    {
        $this->supertype = $supertype;

        return $this;
    }

    public function getSeries(): ?string
    {
        return $this->series;
    }

    public function setSeries(string $series): self
    {
        $this->series = $series;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getTotalSet(): ?int
    {
        return $this->totalSet;
    }

    public function setTotalSet(int $totalSet): self
    {
        $this->totalSet = $totalSet;

        return $this;
    }

    public function getRarity(): ?string
    {
        return $this->rarity;
    }

    public function setRarity(string $rarity): self
    {
        $this->rarity = $rarity;

        return $this;
    }

    public function getPrintedTotal(): ?int
    {
        return $this->printedTotal;
    }

    public function setPrintedTotal(int $printedTotal): self
    {
        $this->printedTotal = $printedTotal;

        return $this;
    }

    public function getTrendPrice(): ?int
    {
        return $this->trendPrice;
    }

    public function setTrendPrice(int $trendPrice): self
    {
        $this->trendPrice = $trendPrice;

        return $this;
    }

    public function getArtist(): ?string
    {
        return $this->artist;
    }

    public function setArtist(string $artist): self
    {
        $this->artist = $artist;

        return $this;
    }

    public function getEvolvesTo(): ?string
    {
        return $this->evolvesTo;
    }

    public function setEvolvesTo(string $evolvesTo): self
    {
        $this->evolvesTo = $evolvesTo;

        return $this;
    }

    /**
     * @return Collection<int, Search>
     */
    public function getSearches(): Collection
    {
        return $this->searches;
    }

    public function addSearch(Search $search): self
    {
        if (!$this->searches->contains($search)) {
            $this->searches->add($search);
            $search->addCard($this);
        }

        return $this;
    }

    public function removeSearch(Search $search): self
    {
        if ($this->searches->removeElement($search)) {
            $search->removeCard($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getCollectors(): Collection
    {
        return $this->collectors;
    }

    public function addCollector(User $collector): self
    {
        if (!$this->collectors->contains($collector)) {
            $this->collectors->add($collector);
            $collector->addCollection($this);
        }

        return $this;
    }

    public function removeCollector(User $collector): self
    {
        if ($this->collectors->removeElement($collector)) {
            $collector->removeCollection($this);
        }

        return $this;
    }
}
