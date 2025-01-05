<?php

namespace App\Entity;

use App\Repository\MoviesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;

#[ORM\Entity(repositoryClass: MoviesRepository::class)]
#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => 'movies:item']),
        new GetCollection(normalizationContext: ['groups' => 'movies:list']),
    ],
    order: ['releaseDate' => 'DESC']
)]
class Movies
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['movies:list', 'movies:item'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['movies:list', 'movies:item'])]
    private ?string $title = null;

    #[ORM\Column(type: 'date')]
    #[Groups(['movies:item'])]
    private ?\DateTimeInterface $releaseDate = null;

    #[ORM\Column(type: 'text')]
    #[Groups(['movies:item'])]
    private ?string $summary = null;

    #[ORM\ManyToMany(targetEntity: MoviesCategories::class, inversedBy: 'movies')]
    #[Groups(['movies:item'])]
    private Collection $categories;

    #[ORM\Column(length: 255)]
    #[Groups(['movies:item'])]
    private ?string $director = null;

    #[ORM\Column(type: 'json')]
    #[Groups(['movies:item'])]
    private array $actors = [];

    #[ORM\Column]
    #[Groups(['movies:list', 'movies:item'])]
    private int $likes = 0;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['movies:list', 'movies:item'])]
    private ?string $image = null;

    #[ORM\OneToMany(mappedBy: 'movie', targetEntity: Comment::class, cascade: ['persist', 'remove'])]
    #[Groups(['movies:item'])]
    private Collection $comments;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    // Getters and setters


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(\DateTimeInterface $releaseDate): self
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(string $summary): self
    {
        $this->summary = $summary;

        return $this;
    }

    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(MoviesCategories $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(MoviesCategories $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }

    public function getDirector(): ?string
    {
        return $this->director;
    }

    public function setDirector(string $director): self
    {
        $this->director = $director;

        return $this;
    }

    public function getActors(): array
    {
        return $this->actors;
    }

    public function setActors(array $actors): self
    {
        $this->actors = $actors;

        return $this;
    }

    public function getLikes(): int
    {
        return $this->likes;
    }

    public function setLikes(int $likes): self
    {
        $this->likes = $likes;

        return $this;
    }

    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setMovie($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getMovie() === $this) {
                $comment->setMovie(null);
            }
        }

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }
}
