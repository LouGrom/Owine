<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompanyRepository::class)
 */
class Company
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
     * @ORM\Column(type="string", length=25)
     */
    private $siret;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $vat;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="company")
     */
    private $seller;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $picture;

    /**
     * @ORM\Column(type="integer")
     */
    private $validated;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $presentation;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $rate;

    public function __construct()
    {
        $this->seller = new ArrayCollection();
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

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(string $siret): self
    {
        $this->siret = $siret;

        return $this;
    }

    public function getVat(): ?string
    {
        return $this->vat;
    }

    public function setVat(string $vat): self
    {
        $this->vat = $vat;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getSeller(): Collection
    {
        return $this->seller;
    }

    public function addSeller(User $seller): self
    {
        if (!$this->seller->contains($seller)) {
            $this->seller[] = $seller;
            $seller->setCompany($this);
        }

        return $this;
    }

    public function removeSeller(User $seller): self
    {
        if ($this->seller->contains($seller)) {
            $this->seller->removeElement($seller);
            // set the owning side to null (unless already changed)
            if ($seller->getCompany() === $this) {
                $seller->setCompany(null);
            }
        }

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

    public function getValidated(): ?int
    {
        return $this->validated;
    }

    public function setValidated(int $validated): self
    {
        $this->validated = $validated;

        return $this;
    }

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(?string $presentation): self
    {
        $this->presentation = $presentation;

        return $this;
    }

    public function getRate(): ?float
    {
        return $this->rate;
    }

    public function setRate(?float $rate): self
    {
        $this->rate = $rate;

        return $this;
    }
}
