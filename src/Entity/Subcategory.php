<?php

namespace App\Entity;

use App\Repository\SubcategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubcategoryRepository::class)]
class Subcategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $status;

    #[ORM\ManyToMany(targetEntity: Book::class, mappedBy: 'subcategories')]
    private $subcategorybook;

    public function __construct()
    {
        $this->subcategorybook = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection<int, Book>
     */
    public function getSubcategorybook(): Collection
    {
        return $this->subcategorybook;
    }

    public function addSubcategorybook(Book $subcategorybook): self
    {
        if (!$this->subcategorybook->contains($subcategorybook)) {
            $this->subcategorybook[] = $subcategorybook;
        }

        return $this;
    }

    public function removeSubcategorybook(Book $subcategorybook): self
    {
        $this->subcategorybook->removeElement($subcategorybook);

        return $this;
    }

      /**
     * Generates the magic method
     * 
     */
    public function __toString(){
        // to show the name of the Category in the select
        return $this->name;
        // to show the id of the Category in the select
        // return $this->id;
    }
}
