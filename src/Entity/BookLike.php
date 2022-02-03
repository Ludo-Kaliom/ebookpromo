<?php

namespace App\Entity;

use App\Repository\BookLikeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookLikeRepository::class)]
class BookLike
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Book::class, inversedBy: 'bookLikes')]
    #[ORM\JoinColumn(nullable: false)]
    private $book;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'bookLikes')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): self
    {
        $this->book = $book;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
