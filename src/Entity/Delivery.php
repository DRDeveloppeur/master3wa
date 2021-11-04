<?php

namespace App\Entity;

use App\Repository\DeliveryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DeliveryRepository::class)
 */
class Delivery
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $threshold;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $price_before;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $price_after;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

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

    public function getThreshold(): ?float
    {
        return $this->threshold;
    }

    public function setThreshold(?float $threshold): self
    {
        $this->threshold = $threshold;

        return $this;
    }

    public function getPriceBefore(): ?float
    {
        return $this->price_before;
    }

    public function setPriceBefore(?float $price_before): self
    {
        $this->price_before = $price_before;

        return $this;
    }

    public function getPriceAfter(): ?float
    {
        return $this->price_after;
    }

    public function setPriceAfter(?float $price_after): self
    {
        $this->price_after = $price_after;

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

    public function __toString()
    {
        return $this->name;
    }
}
