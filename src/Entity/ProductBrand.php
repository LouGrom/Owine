<?php

namespace App\Entity;

use App\Repository\ProductBrandRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductBrandRepository::class)
 */
class ProductBrand
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
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $picture;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $selection_filter;

    /**
     * @ORM\OneToOne(targetEntity=Product::class, mappedBy="brand", cascade={"persist", "remove"})
     */
    private $product;

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

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getSelectionFilter(): ?string
    {
        return $this->selection_filter;
    }

    public function setSelectionFilter(?string $selection_filter): self
    {
        $this->selection_filter = $selection_filter;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): self
    {
        $this->product = $product;

        // set the owning side of the relation if necessary
        if ($product->getBrand() !== $this) {
            $product->setBrand($this);
        }

        return $this;
    }
}
