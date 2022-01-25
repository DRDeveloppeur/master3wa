<?php

namespace App\Entity;

use App\Repository\BasketRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BasketRepository::class)
 */
class Basket
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ref_order;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_payed;

    /**
     * @ORM\ManyToOne(targetEntity=Delivery::class)
     */
    private $delivery_id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="baskets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_id;

    /**
     * @ORM\OneToOne(targetEntity=Invoice::class, mappedBy="basket_id", cascade={"persist", "remove"})
     */
    private $invoice;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="basket_id", orphanRemoval=true)
     */
    private $orders;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getRefOrder(): ?string
    {
        return $this->ref_order;
    }

    public function setRefOrder(string $ref_order): self
    {
        $this->ref_order = $ref_order;

        return $this;
    }

    public function getIsPayed(): ?bool
    {
        return $this->is_payed;
    }

    public function setIsPayed(bool $is_payed): self
    {
        $this->is_payed = $is_payed;

        return $this;
    }

    public function getDeliveryId(): ?Delivery
    {
        return $this->delivery_id;
    }

    public function setDeliveryId(?Delivery $delivery_id): self
    {
        $this->delivery_id = $delivery_id;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getInvoice(): ?Invoice
    {
        return $this->invoice;
    }

    public function setInvoice(Invoice $invoice): self
    {
        // set the owning side of the relation if necessary
        if ($invoice->getBasketId() !== $this) {
            $invoice->setBasketId($this);
        }

        $this->invoice = $invoice;

        return $this;
    }

    /**
     * @return Collection|Order[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setBasketId($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getBasketId() === $this) {
                $order->setBasketId(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name." - ".$this->getUserId()->getFirstname();
    }
}
