<?php

namespace App\Entity;

use App\Repository\MoviesCategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;

#[ORM\Entity(repositoryClass: MoviesCategoriesRepository::class)]
#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => 'category:item']),
        new GetCollection(normalizationContext: ['groups' => 'category:list']),
    ],
    paginationEnabled: false
)]
class MoviesCategories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['category:list', 'category:item', 'movies:item'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['category:list', 'category:item', 'movies:item'])]
    private ?int $customId = null;

    #[ORM\Column(length: 255)]
    #[Groups(['category:list', 'category:item', 'movies:item'])]
    private ?string $categoryName = null;

    #[ORM\ManyToMany(targetEntity: Movies::class, mappedBy: 'categories')]
    private Collection $movies;

    public function __construct()
    {
        $this->movies = new ArrayCollection();
    }

    // Getters et setters...
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomId(): ?int
    {
        return $this->customId;
    }

    public function setCustomId(int $customId): self
    {
        $this->customId = $customId;

        return $this;
    }

    public function getCategoryName(): ?string
    {
        return $this->categoryName;
    }

    public function setCategoryName(string $categoryName): self
    {
        $this->categoryName = $categoryName;

        return $this;
    }

    public function getMovies(): Collection
    {
        return $this->movies;
    }

    public function addMovie(Movies $movie): self
    {
        if (!$this->movies->contains($movie)) {
            $this->movies->add($movie);
            $movie->addCategory($this);
        }

        return $this;
    }

    public function removeMovie(Movies $movie): self
    {
        if ($this->movies->removeElement($movie)) {
            $movie->removeCategory($this); // Synchronisation bidirectionnelle
        }
        return $this;
    }
}
