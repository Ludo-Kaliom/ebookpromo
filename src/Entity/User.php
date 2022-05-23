<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @UniqueEntity(fields={"email"}, message="Il existe déjà un compte possédant cet email, veuillez en choisir un autre email")
 */
#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $email;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    private $password;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private $username;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $avatar;

    #[ORM\Column(type: 'datetime')]
    private $registrationdate;

    #[ORM\Column(type: 'datetime')]
    private $updated;

    #[ORM\Column(type: 'boolean')]
    private $subscription;

    #[ORM\Column(type: 'boolean')]
    private $status;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Book::class)]
    private $books;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Comment::class)]
    private $Comments;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: BookLike::class)]
    private $bookLikes;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Article::class)]
    private $article;

    #[ORM\OneToMany(mappedBy: 'username', targetEntity: Answer::class)]
    private $answers;

    #[ORM\OneToMany(mappedBy: 'username', targetEntity: Message::class)]
    private $messages;

    #[ORM\OneToMany(mappedBy: 'adminname', targetEntity: Message::class)]
    private $adminmessages;

    public function __construct()
    {
        $this->books = new ArrayCollection();
        $this->Comments = new ArrayCollection();
        $this->bookLikes = new ArrayCollection();
        $this->article = new ArrayCollection();
        $this->answers = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->adminmessages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return string the hashed password for this user
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getRegistrationdate(): ?\DateTimeInterface
    {
        return $this->registrationdate;
    }

    public function setRegistrationdate(\DateTimeInterface $registrationdate): self
    {
        $this->registrationdate = $registrationdate;

        return $this;
    }

    public function getUpdated(): ?\DateTimeInterface
    {
        return $this->updated;
    }

    public function setUpdated(?\DateTimeInterface $updated): self
    {
        $this->updated = $updated;

        return $this;
    }

    public function getSubscription(): ?bool
    {
        return $this->subscription;
    }

    public function setSubscription(?bool $subscription): self
    {
        $this->subscription = $subscription;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(?bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection|Book[]
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function addBook(Book $book): self
    {
        if (!$this->books->contains($book)) {
            $this->books[] = $book;
            $book->setUser($this);
        }

        return $this;
    }

    public function removeBook(Book $book): self
    {
        if ($this->books->removeElement($book)) {
            // set the owning side to null (unless already changed)
            if ($book->getUser() === $this) {
                $book->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->Comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->Comments->contains($comment)) {
            $this->Comments[] = $comment;
            $comment->setUser($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->Comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getUser() === $this) {
                $comment->setUser(null);
            }
        }

        return $this;
    }

    /**
     * Generates the magic method
     * 
     */
    public function __toString(){
        // to show the name of the Category in the select
        return $this->username;
        // to show the id of the Category in the select
        // return $this->id;
    }

    /**
     * @return Collection|BookLike[]
     */
    public function getBookLikes(): Collection
    {
        return $this->bookLikes;
    }

    public function addBookLike(BookLike $bookLike): self
    {
        if (!$this->bookLikes->contains($bookLike)) {
            $this->bookLikes[] = $bookLike;
            $bookLike->setUser($this);
        }

        return $this;
    }

    public function removeBookLike(BookLike $bookLike): self
    {
        if ($this->bookLikes->removeElement($bookLike)) {
            // set the owning side to null (unless already changed)
            if ($bookLike->getUser() === $this) {
                $bookLike->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticle(): Collection
    {
        return $this->article;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->article->contains($article)) {
            $this->article[] = $article;
            $article->setUser($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->article->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getUser() === $this) {
                $article->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Answer>
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function addAnswer(Answer $answer): self
    {
        if (!$this->answers->contains($answer)) {
            $this->answers[] = $answer;
            $answer->setUsername($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): self
    {
        if ($this->answers->removeElement($answer)) {
            // set the owning side to null (unless already changed)
            if ($answer->getUsername() === $this) {
                $answer->setUsername(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setUsername($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getUsername() === $this) {
                $message->setUsername(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getAdminmessages(): Collection
    {
        return $this->adminmessages;
    }

    public function addAdminmessage(Message $adminmessage): self
    {
        if (!$this->adminmessages->contains($adminmessage)) {
            $this->adminmessages[] = $adminmessage;
            $adminmessage->setAdminname($this);
        }

        return $this;
    }

    public function removeAdminmessage(Message $adminmessage): self
    {
        if ($this->adminmessages->removeElement($adminmessage)) {
            // set the owning side to null (unless already changed)
            if ($adminmessage->getAdminname() === $this) {
                $adminmessage->setAdminname(null);
            }
        }

        return $this;
    }

}
