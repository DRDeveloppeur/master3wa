<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $ref;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $model;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tag;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ray;

    /**
     * @ORM\ManyToOne(targetEntity=Mark::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $mark_id;

    /**
     * @ORM\ManyToOne(targetEntity=SubCategorie::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sub_categorie_id;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie_id;

    /**
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="product_id", orphanRemoval=true)
     */
    private $images;

    /**
     * @ORM\OneToMany(targetEntity=Stock::class, mappedBy="product_id", orphanRemoval=true)
     */
    private $stocks;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->stocks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRef(): ?int
    {
        return $this->ref;
    }

    public function setRef(int $ref): self
    {
        $this->ref = $ref;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getTag(): ?string
    {
        return $this->tag;
    }

    public function setTag(?string $tag): self
    {
        $this->tag = $tag;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getRay(): ?string
    {
        return $this->ray;
    }

    public function setRay(string $ray): self
    {
        $this->ray = $ray;

        return $this;
    }

    public function getMarkId(): ?Mark
    {
        return $this->mark_id;
    }

    public function setMarkId(?Mark $mark_id): self
    {
        $this->mark_id = $mark_id;

        return $this;
    }

    public function getSubCategorieId(): ?SubCategorie
    {
        return $this->sub_categorie_id;
    }

    public function setSubCategorieId(?SubCategorie $sub_categorie_id): self
    {
        $this->sub_categorie_id = $sub_categorie_id;

        return $this;
    }

    public function getCategorieId(): ?Categorie
    {
        return $this->categorie_id;
    }

    public function setCategorieId(?Categorie $categorie_id): self
    {
        $this->categorie_id = $categorie_id;

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setProductId($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getProductId() === $this) {
                $image->setProductId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Stock[]
     */
    public function getStocks(): Collection
    {
        return $this->stocks;
    }

    public function addStock(Stock $stock): self
    {
        if (!$this->stocks->contains($stock)) {
            $this->stocks[] = $stock;
            $stock->setProductId($this);
        }

        return $this;
    }

    public function removeStock(Stock $stock): self
    {
        if ($this->stocks->removeElement($stock)) {
            // set the owning side to null (unless already changed)
            if ($stock->getProductId() === $this) {
                $stock->setProductId(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->ref." - ".$this->model;;
    }
}
