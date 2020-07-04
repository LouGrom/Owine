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
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $appellation;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $area;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $cuvee_domaine;

    /**
     * @ORM\Column(type="float")
     */
    private $capacity;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $vintage;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $color;

    /**
     * @ORM\Column(type="float")
     */
    private $alcohol_volume;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $hs_code;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $picture;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="products_for_sale")
     * @ORM\JoinColumn(nullable=false)
     */
    private $seller;

    /**
     * @ORM\OneToMany(targetEntity=ProductCategory::class, mappedBy="product")
     */
    private $category;

    /**
     * @ORM\OneToOne(targetEntity=ProductBrand::class, inversedBy="product", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $brand;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="products")
     */
    private $order_product;

    public function __construct()
    {
        $this->category = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAppellation(): ?string
    {
        return $this->appellation;
    }

    public function setAppellation(string $appellation): self
    {
        $this->appellation = $appellation;

        return $this;
    }

    public function getArea(): ?string
    {
        return $this->area;
    }

    public function setArea(string $area): self
    {
        $this->area = $area;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCuveeDomaine(): ?string
    {
        return $this->cuvee_domaine;
    }

    public function setCuveeDomaine(string $cuvee_domaine): self
    {
        $this->cuvee_domaine = $cuvee_domaine;

        return $this;
    }

    public function getCapacity(): ?string
    {
        return $this->capacity;
    }

    public function setCapacity(string $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function getVintage(): ?string
    {
        return $this->vintage;
    }

    public function setVintage(string $vintage): self
    {
        $this->vintage = $vintage;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getAlcoholVolume(): ?string
    {
        return $this->alcohol_volume;
    }

    public function setAlcoholVolume(string $alcohol_volume): self
    {
        $this->alcohol_volume = $alcohol_volume;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getHsCode(): ?string
    {
        return $this->hs_code;
    }

    public function setHsCode(string $hs_code): self
    {
        $this->hs_code = $hs_code;

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

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

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

    /**
     * @return Collection|ProductCategory[]
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(ProductCategory $category): self
    {
        if (!$this->category->contains($category)) {
            $this->category[] = $category;
            $category->setProduct($this);
        }

        return $this;
    }

    public function removeCategory(ProductCategory $category): self
    {
        if ($this->category->contains($category)) {
            $this->category->removeElement($category);
            // set the owning side to null (unless already changed)
            if ($category->getProduct() === $this) {
                $category->setProduct(null);
            }
        }

        return $this;
    }

    public function getBrand(): ?ProductBrand
    {
        return $this->brand;
    }

    public function setBrand(ProductBrand $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getOrderProduct(): ?Order
    {
        return $this->order_product;
    }

    public function setOrderProduct(?Order $order_product): self
    {
        $this->order_product = $order_product;

        return $this;
    }
}
