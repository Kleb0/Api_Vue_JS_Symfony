<?php

namespace App\Entity;

use App\Repository\UserRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => 'user:item']),
        new GetCollection(normalizationContext: ['groups' => 'user:list'])
    ],
    order: ['email' => 'ASC'],
    paginationEnabled: false
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface 
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user:list', 'user:item'])]
    private ?int $id = null;

    #[ORM\Column(nullable: false)]
    #[Groups(['user:list', 'user:item'])]
    private ?int $customId = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:list', 'user:item'])]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:item'])] 
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:list', 'user:item'])]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:list', 'user:item'])]
    private ?string $lastName = null;


    #[ORM\Column(length: 255)]
    #[Groups(['user:list', 'user:item'])]
    private ?string $streetName = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:list', 'user:item'])]
    private ?int $streetNumber = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:list', 'user:item'])]
    private ?string $city = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:list', 'user:item'])]
    private ?int $postalCode = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['user:item'])]
    private ?string $comments = null;

    #[ORM\Column]
    #[Groups(['user:item'])]
    private ?int $commentsId = null;

    #[ORM\ManyToOne(targetEntity: Role::class, inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['user:item'])]
    private ?Role $role = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:list', 'user:item'])]
    private ?string $roleName = null;

    #[ORM\Column]
    #[Groups(['user:list', 'user:item'])]
    private ?int $roleId = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['user:item'])]
    private ?string $movies_liked = null;

    #[ORM\Column]
    #[Groups(['user:list', 'user:item'])]
    private ?int $likes = null;

    #[ORM\Column(type: 'string', length: 255, unique: true, nullable: true)]
    private ?string $apiToken = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomId(): ?int
    {
        return $this->customId;
    }

    public function setCustomId(int $customId): static
    {
        $this->customId = $customId;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getStreetName(): ?string
    {
        return $this->streetName;
    }

    public function setStreetName(string $streetName): static
    {
        $this->streetName = $streetName;

        return $this;
    }

    public function getStreetNumber(): ?int
    {
        return $this->streetNumber;
    }

    public function setStreetNumber(int $streetNumber): static
    {
        $this->streetNumber = $streetNumber;

        return $this;
    }

    public function getPostalCode(): ?int
    {
        return $this->postalCode;
    }

    public function setPostalCode(int $postalCode): static
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    

    public function getComments(): ?string
    {
        return $this->comments;
    }

    public function setComments(string $comments): static
    {
        $this->comments = $comments;

        return $this;
    }

    public function getCommentsId(): ?int
    {
        return $this->commentsId;
    }

    public function setCommentsId(int $commentsId): static
    {
        $this->commentsId = $commentsId;

        return $this;
    }

    public function getRoleName(): ?string
    {
        $roles = $this->getRoles();
        return $roles[0] ?? 'USER';
    }

    public function setRoleName(string $roleName): static
    {
        $this->roleName = $roleName;
        return $this;
    }

    public function getRoleId(): ?int
    {
        return $this->roleId;
    }

    public function setRoleId(int $roleId): static
    {
        $this->roleId = $roleId;

        return $this;
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): static
    {
        $this->role = $role;

        return $this;
    }
    public function getMoviesLiked(): ?string
    {
        return $this->movies_liked;
    }

    public function setMoviesLiked(string $movies_liked): static
    {
        $this->movies_liked = $movies_liked;

        return $this;
    }

    public function getLikes(): ?int
    {
        return $this->likes;
    }

    public function setLikes(int $likes): static
    {
        $this->likes = $likes;

        return $this;
    }

    public function getApiToken(): ?string
    {
        return $this->apiToken;
    }

    public function setApiToken(?string $apiToken): self
    {
        $this->apiToken = $apiToken;
        return $this;
    }
    public function getRoles(): array
    {
        return [$this->roleName];
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function getUsername(): string
    {
        return $this->email;
    }

    public function getUserIdentifier(): string
    {
        return $this->email; // Retourne l'identifiant unique de l'utilisateur
    }

    public function eraseCredentials(): void
    {
        // Pas de logique particulière ici si vous n'avez pas de données sensibles à nettoyer.
    }

    }
