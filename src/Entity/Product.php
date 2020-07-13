<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Groups({"searchable"})
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank
     * @Assert\Length(max=50)
     */
<<<<<<< HEAD
    private $appellation;

    /**
     * @Groups({"searchable"})
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank
     * @Assert\Length(max=50)
     */
=======
>>>>>>> master
    private $area;

    /**
     * @Groups({"searchable"})
     * @ORM\Column(type="string", length=30)
     * @Assert\NotBlank
     * @Assert\Length(max=30)
     */
    private $cuveeDomaine;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank
     */
    private $capacity;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\NotBlank
     * @Assert\Length(max=20)
     */
    private $vintage;

    /**
     * @ORM\Column(type="float")
     */
    private $alcoholVolume;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=130)
     * @Assert\NotBlank
     * @Assert\Length(max=130)
     */
    private $hsCode;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $picture;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="productsForSale")
     * @ORM\JoinColumn(nullable=false)
     */
    private $seller;

    /**
     * @ORM\OneToMany(targetEntity=ProductCategory::class, mappedBy="product")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity=ProductBrand::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $brand;

    /**
     * @ORM\OneToMany(targetEntity=OrderProduct::class, mappedBy="product")
     */
    private $orderProducts;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $stockQuantity;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Color::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $color;

    /**
     * @ORM\ManyToOne(targetEntity=Type::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $rate;

    /**
     * @ORM\OneToOne(targetEntity=Appellation::class, mappedBy="product", cascade={"persist", "remove"})
     */
    private $appellation;

    public function __construct()
    {
        $this->category = new ArrayCollection();
        $this->orderProducts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCuveeDomaine(): ?string
    {
        return $this->cuveeDomaine;
    }

    public function setCuveeDomaine(string $cuveeDomaine): self
    {
        $this->cuveeDomaine = $cuveeDomaine;

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

    public function getAlcoholVolume(): ?string
    {
        return $this->alcoholVolume;
    }

    public function setAlcoholVolume(string $alcoholVolume): self
    {
        $this->alcoholVolume = $alcoholVolume;

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
        return $this->hsCode;
    }

    public function setHsCode(string $hsCode): self
    {
        $this->hsCode = $hsCode;

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

    public function setBrand(?ProductBrand $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @return Collection|OrderProduct[]
     */
    public function getOrderProducts(): Collection
    {
        return $this->orderProducts;
    }

    public function addOrderProduct(OrderProduct $orderProduct): self
    {
        if (!$this->orderProducts->contains($orderProduct)) {
            $this->orderProducts[] = $orderProduct;
            $orderProduct->setProduct($this);
        }

        return $this;
    }

    public function removeOrderProduct(OrderProduct $orderProduct): self
    {
        if ($this->orderProducts->contains($orderProduct)) {
            $this->orderProducts->removeElement($orderProduct);
            // set the owning side to null (unless already changed)
            if ($orderProduct->getProduct() === $this) {
                $orderProduct->setProduct(null);
            }
        }

        return $this;
    }

    public function getStockQuantity(): ?int
    {
        return $this->stockQuantity;
    }

    public function setStockQuantity(?int $stockQuantity): self
    {
        $this->stockQuantity = $stockQuantity;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getColor(): ?Color
    {
        return $this->color;
    }

    public function setColor(?Color $color): self
    {
        $this->color = $color;

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

<<<<<<< HEAD
    // Méthode permettant de transformer les objets address en format JSON afin de pouvoir exploiter les données saisies dans le cadre de l'utilisation de l'API d'Algolia pour faire des recherches sur les données de l'application
    public function normalize(NormalizerInterface $serializer, $format = null, array $context = []): array
    {
        return [
            'appellation' => $this->getAppellation(),
            'area' => $this->getArea(),
            'cuveeDomaine' => $this->getCuveeDomaine(),

            // Reuse the $serializer
            'appellation' => $serializer->normalize($this->getAppellation(), $format, $context),
            'area' => $serializer->normalize($this->getArea(), $format, $context),
            'cuveeDomaine' => $serializer->normalize($this->getCuveeDomaine(), $format, $context),
        ];
=======
    public function getRate(): ?float
    {
        return $this->rate;
    }

    public function setRate(?float $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getAppellation(): ?Appellation
    {
        return $this->appellation;
    }

    public function setAppellation(Appellation $appellation): self
    {
        $this->appellation = $appellation;

        // set the owning side of the relation if necessary
        if ($appellation->getProduct() !== $this) {
            $appellation->setProduct($this);
        }

        return $this;
>>>>>>> master
    }
}
