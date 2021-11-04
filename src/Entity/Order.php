<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
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
    private $amount;

    /**
     * @ORM\ManyToOne(targetEntity=Basket::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $basket_id;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $product_id;

    /**
     * @ORM\ManyToOne(targetEntity=Stock::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $stock_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getBasketId(): ?Basket
    {
        return $this->basket_id;
    }

    public function setBasketId(?Basket $basket_id): self
    {
        $this->basket_id = $basket_id;

        return $this;
    }

    public function getProductId(): ?Product
    {
        return $this->product_id;
    }

    public function setProductId(?Product $product_id): self
    {
        $this->product_id = $product_id;

        return $this;
    }

    public function getStockId(): ?Stock
    {
        return $this->stock_id;
    }

    public function setStockId(?Stock $stock_id): self
    {
        $this->stock_id = $stock_id;

        return $this;
    }
}
