<?php

namespace App\Entity;

use App\Repository\UserRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
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
class User implements PasswordAuthenticatedUserInterface
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
    private ?string $adress = null;

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

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): static
    {
        $this->adress = $adress;

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
        return $this->roleName;
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
}
