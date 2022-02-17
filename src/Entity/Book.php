<?php

namespace App\Entity;

use App\Entity\User;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BookRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'string', length: 13)]
    private $isbn;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\Column(type: 'string', length: 255)]
    private $cover;

    #[ORM\Column(type: 'float')]
    private $normalprice;

    #[ORM\Column(type: 'float')]
    private $reduceprice;

    #[ORM\Column(type: 'datetime')]
    private $startdate;

    #[ORM\Column(type: 'datetime')]
    private $enddate;

    #[ORM\Column(type: 'string', length: 255)]
    private $link;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $status;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'books')]
    private $user;

    #[ORM\OneToMany(mappedBy: 'book', targetEntity: Comment::class, orphanRemoval: true)]
    private $comments;

    #[ORM\Column(type: 'string', length: 255)]
    private $publisher;

    #[ORM\Column(type: 'string', length: 255)]
    private $authors;

    #[ORM\OneToMany(mappedBy: 'book', targetEntity: BookLike::class, orphanRemoval: true)]
    private $bookLikes;

    #[ORM\ManyToOne(targetEntity: Type::class, inversedBy: 'books')]
    #[ORM\JoinColumn(nullable: false)]
    private $type;

    #[ORM\Column(type: 'integer')]
    private $totalprice;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'books')]
    #[ORM\JoinColumn(nullable: false)]
    private $category;

    #[ORM\ManyToOne(targetEntity: Subcategory::class, inversedBy: 'books')]
    #[ORM\JoinColumn(nullable: false)]
    private $subcategory;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $nbcomments;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $nblikes;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->bookLikes = new ArrayCollection();
    }

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

    public function getSlug(): string
    {
        return (new Slugify())->slugify($this->title);
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): self
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(string $cover): self
    {
        $this->cover = $cover;

        return $this;
    }

    public function getNormalprice(): ?float
    {
        return $this->normalprice;
    }

    public function setNormalprice(float $normalprice): self
    {
        $this->normalprice = $normalprice;

        return $this;
    }

    public function getReduceprice(): ?float
    {
        return $this->reduceprice;
    }

    public function setReduceprice(float $reduceprice): self
    {
        $this->reduceprice = $reduceprice;

        return $this;
    }

    public function getStartdate(): ?\DateTimeInterface
    {
        return $this->startdate;
    }

    public function setStartdate(\DateTimeInterface $startdate): self
    {
        $this->startdate = $startdate;

        return $this;
    }

    public function getEnddate(): ?\DateTimeInterface
    {
        return $this->enddate;
    }

    public function setEnddate(\DateTimeInterface $enddate): self
    {
        $this->enddate = $enddate;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setBook($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getBook() === $this) {
                $comment->setBook(null);
            }
        }

        return $this;
    }

    public function getPublisher(): ?string
    {
        return $this->publisher;
    }

    public function setPublisher(string $publisher): self
    {
        $this->publisher = $publisher;

        return $this;
    }

    public function getAuthors(): ?string
    {
        return $this->authors;
    }

    public function setAuthors(string $authors): self
    {
        $this->authors = $authors;

        return $this;
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
            $bookLike->setBook($this);
        }

        return $this;
    }

    public function removeBookLike(BookLike $bookLike): self
    {
        if ($this->bookLikes->removeElement($bookLike)) {
            // set the owning side to null (unless already changed)
            if ($bookLike->getBook() === $this) {
                $bookLike->setBook(null);
            }
        }

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getTotalprice(): ?float
    {
        return $this->totalprice;
    }

    public function setTotalprice(float $totalprice): self
    {
        $this->totalprice = $totalprice;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getSubcategory(): ?Subcategory
    {
        return $this->subcategory;
    }

    public function setSubcategory(?Subcategory $subcategory): self
    {
        $this->subcategory = $subcategory;

        return $this;
    }

    public function getNbcomments(): ?int
    {
        return $this->nbcomments;
    }

    public function setNbcomments(?int $nbcomments): self
    {
        $this->nbcomments = $nbcomments;

        return $this;
    }


    /**
     * Permet de savoir si un livre est liké par un utilisateur
     *
     * @param User $user
     * @return boolean
     */
    public function isLikedByUser(User $user): bool {
        foreach($this->bookLikes as $booklike){
            if($booklike->getUser() === $user) return true;
        }
        return false;
    }

    public function getNblikes(): ?int
    {
        return $this->nblikes;
    }

    public function setNblikes(?int $nblikes): self
    {
        $this->nblikes = $nblikes;

        return $this;
    }
    
}
