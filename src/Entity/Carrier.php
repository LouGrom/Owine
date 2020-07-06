<?php

namespace App\Entity;

use App\Repository\CarrierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="carrier")
     */
    private $delivery;

    public function __construct()
    {
        $this->delivery = new ArrayCollection();
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

    public function getMode(): ?string
    {
        return $this->mode;
    }

    public function setMode(?string $mode): self
    {
        $this->mode = $mode;

        return $this;
    }

    /**
     * @return Collection|Order[]
     */
    public function getDelivery(): Collection
    {
        return $this->delivery;
    }

    public function addDelivery(Order $delivery): self
    {
        if (!$this->delivery->contains($delivery)) {
            $this->delivery[] = $delivery;
            $delivery->setCarrier($this);
        }

        return $this;
    }

    public function removeDelivery(Order $delivery): self
    {
        if ($this->delivery->contains($delivery)) {
            $this->delivery->removeElement($delivery);
            // set the owning side to null (unless already changed)
            if ($delivery->getCarrier() === $this) {
                $delivery->setCarrier(null);
            }
        }

        return $this;
    }
}
