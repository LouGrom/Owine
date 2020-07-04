<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $total_quantity;

    /**
     * @ORM\Column(type="float")
     */
    private $total_amount;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $tracking_number;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="received_order")
     * @ORM\JoinColumn(nullable=false)
     */
    private $seller;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="sent_order")
     * @ORM\JoinColumn(nullable=false)
     */
    private $buyer;

    /**
     * @ORM\OneToMany(targetEntity=Product::class, mappedBy="order_product")
     */
    private $products;

    /**
     * @ORM\OneToOne(targetEntity=Carrier::class, inversedBy="delivery", cascade={"persist", "remove"})
     */
    private $carrier;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTotalQuantity(): ?string
    {
        return $this->total_quantity;
    }

    public function setTotalQuantity(string $total_quantity): self
    {
        $this->total_quantity = $total_quantity;

        return $this;
    }

    public function getTotalAmount(): ?float
    {
        return $this->total_amount;
    }

    public function setTotalAmount(float $total_amount): self
    {
        $this->total_amount = $total_amount;

        return $this;
    }

    public function getTrackingNumber(): ?string
    {
        return $this->tracking_number;
    }

    public function setTrackingNumber(string $tracking_number): self
    {
        $this->tracking_number = $tracking_number;

        return $this;
    }

    public function getSeller(): ?User
    {
        return $this->seller;
    }

    public function setSeller(?User $seller): self
    {
        $this->seller = $seller;

        return $this;
    }

    public function getBuyer(): ?User
    {
        return $this->buyer;
    }

    public function setBuyer(?User $buyer): self
    {
        $this->buyer = $buyer;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setOrderProduct($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            // set the owning side to null (unless already changed)
            if ($product->getOrderProduct() === $this) {
                $product->setOrderProduct(null);
            }
        }

        return $this;
    }

    public function getCarrier(): ?Carrier
    {
        return $this->carrier;
    }

    public function setCarrier(?Carrier $carrier): self
    {
        $this->carrier = $carrier;

        return $this;
    }
}
