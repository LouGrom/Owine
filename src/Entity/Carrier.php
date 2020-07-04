<?php

namespace App\Entity;

use App\Repository\CarrierRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CarrierRepository::class)
 */
class Carrier
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $mode;

    /**
     * @ORM\OneToOne(targetEntity=Order::class, mappedBy="carrier", cascade={"persist", "remove"})
     */
    private $delivery;

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

    public function getMode(): ?string
    {
        return $this->mode;
    }

    public function setMode(?string $mode): self
    {
        $this->mode = $mode;

        return $this;
    }

    public function getDelivery(): ?Order
    {
        return $this->delivery;
    }

    public function setDelivery(?Order $delivery): self
    {
        $this->delivery = $delivery;

        // set (or unset) the owning side of the relation if necessary
        $newCarrier = null === $delivery ? null : $this;
        if ($delivery->getCarrier() !== $newCarrier) {
            $delivery->setCarrier($newCarrier);
        }

        return $this;
    }
}
