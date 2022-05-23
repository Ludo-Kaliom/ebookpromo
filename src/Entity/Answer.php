<?php

namespace App\Entity;

use App\Repository\AnswerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnswerRepository::class)]
class Answer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'text')]
    private $message;

    #[ORM\Column(type: 'datetime')]
    private $createdAt;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'answers')]
    private $username;

    #[ORM\ManyToOne(targetEntity: Message::class, inversedBy: 'answers')]
    private $firstMessage;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUsername(): ?User
    {
        return $this->username;
    }

    public function setUsername(?User $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getFirstMessage(): ?Message
    {
        return $this->firstMessage;
    }

    public function setFirstMessage(?Message $firstMessage): self
    {
        $this->firstMessage = $firstMessage;

        return $this;
    }
}
