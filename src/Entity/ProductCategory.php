<?php

namespace App\Entity;

use App\Repository\ProductCategoryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductCategoryRepository::class)
 */
class ProductCategory
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $selection_filter;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="category")
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

    public function getSelectionFilter(): ?int
    {
        return $this->selection_filter;
    }

    public function setSelectionFilter(int $selection_filter): self
    {
        $this->selection_filter = $selection_filter;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }
}
