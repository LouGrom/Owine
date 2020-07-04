<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $role;

    /**
     * @ORM\Column(type="string", length=40, nullable=true)
     */
    private $company_name;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $zip_code;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $phone_number;

    /**
     * @ORM\Column(type="string", length=14, nullable=true)
     */
    private $siret_number;

    /**
     * @ORM\Column(type="string", length=13, nullable=true)
     */
    private $vat_number;

    /**
     * @ORM\OneToMany(targetEntity=DeliveryAddress::class, mappedBy="buyer")
     */
    private $delivery_address;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="seller")
     */
    private $received_order;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="buyer")
     */
    private $sent_order;

    /**
     * @ORM\OneToMany(targetEntity=Product::class, mappedBy="seller")
     */
    private $products_for_sale;

    public function __construct()
    {
        $this->delivery_address = new ArrayCollection();
        $this->received_order = new ArrayCollection();
        $this->sent_order = new ArrayCollection();
        $this->products_for_sale = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getCompanyName(): ?string
    {
        return $this->company_name;
    }

    public function setCompanyName(?string $company_name): self
    {
        $this->company_name = $company_name;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zip_code;
    }

    public function setZipCode(string $zip_code): self
    {
        $this->zip_code = $zip_code;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(string $phone_number): self
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    public function getSiretNumber(): ?string
    {
        return $this->siret_number;
    }

    public function setSiretNumber(?string $siret_number): self
    {
        $this->siret_number = $siret_number;

        return $this;
    }

    public function getVatNumber(): ?string
    {
        return $this->vat_number;
    }

    public function setVatNumber(?string $vat_number): self
    {
        $this->vat_number = $vat_number;

        return $this;
    }

    /**
     * @return Collection|DeliveryAddress[]
     */
    public function getDeliveryAddress(): Collection
    {
        return $this->delivery_address;
    }

    public function addDeliveryAddress(DeliveryAddress $deliveryAddress): self
    {
        if (!$this->delivery_address->contains($deliveryAddress)) {
            $this->delivery_address[] = $deliveryAddress;
            $deliveryAddress->setBuyer($this);
        }

        return $this;
    }

    public function removeDeliveryAddress(DeliveryAddress $deliveryAddress): self
    {
        if ($this->delivery_address->contains($deliveryAddress)) {
            $this->delivery_address->removeElement($deliveryAddress);
            // set the owning side to null (unless already changed)
            if ($deliveryAddress->getBuyer() === $this) {
                $deliveryAddress->setBuyer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Order[]
     */
    public function getReceivedOrder(): Collection
    {
        return $this->received_order;
    }

    public function addReceivedOrder(Order $receivedOrder): self
    {
        if (!$this->received_order->contains($receivedOrder)) {
            $this->received_order[] = $receivedOrder;
            $receivedOrder->setSeller($this);
        }

        return $this;
    }

    public function removeReceivedOrder(Order $receivedOrder): self
    {
        if ($this->received_order->contains($receivedOrder)) {
            $this->received_order->removeElement($receivedOrder);
            // set the owning side to null (unless already changed)
            if ($receivedOrder->getSeller() === $this) {
                $receivedOrder->setSeller(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Order[]
     */
    public function getSentOrder(): Collection
    {
        return $this->sent_order;
    }

    public function addSentOrder(Order $sentOrder): self
    {
        if (!$this->sent_order->contains($sentOrder)) {
            $this->sent_order[] = $sentOrder;
            $sentOrder->setBuyer($this);
        }

        return $this;
    }

    public function removeSentOrder(Order $sentOrder): self
    {
        if ($this->sent_order->contains($sentOrder)) {
            $this->sent_order->removeElement($sentOrder);
            // set the owning side to null (unless already changed)
            if ($sentOrder->getBuyer() === $this) {
                $sentOrder->setBuyer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProductsForSale(): Collection
    {
        return $this->products_for_sale;
    }

    public function addProductsForSale(Product $productsForSale): self
    {
        if (!$this->products_for_sale->contains($productsForSale)) {
            $this->products_for_sale[] = $productsForSale;
            $productsForSale->setSeller($this);
        }

        return $this;
    }

    public function removeProductsForSale(Product $productsForSale): self
    {
        if ($this->products_for_sale->contains($productsForSale)) {
            $this->products_for_sale->removeElement($productsForSale);
            // set the owning side to null (unless already changed)
            if ($productsForSale->getSeller() === $this) {
                $productsForSale->setSeller(null);
            }
        }

        return $this;
    }
}
