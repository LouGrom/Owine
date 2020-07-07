<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=40, nullable=true)
     */
    private $companyName;

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
    private $address;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $zipCode;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $siretNumber;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $vatNumber;

    /**
     * @ORM\OneToMany(targetEntity=DeliveryAddress::class, mappedBy="buyer")
     */
    private $deliveryAddress;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="buyer")
     */
    private $sentOrder;

    /**
     * @ORM\OneToMany(targetEntity=Product::class, mappedBy="seller")
     */
    private $productsForSale;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToMany(targetEntity=Order::class, mappedBy="seller")
     */
    private $receivedOrders;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    public function __construct()
    {
        $this->deliveryAddress = new ArrayCollection();
        $this->sentOrder = new ArrayCollection();
        $this->productsForSale = new ArrayCollection();
        $this->receivedOrders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(?string $companyName): self
    {
        $this->companyName = $companyName;

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
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode): self
    {
        $this->zipCode = $zipCode;

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
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getSiretNumber(): ?string
    {
        return $this->siretNumber;
    }

    public function setSiretNumber(?string $siretNumber): self
    {
        $this->siretNumber = $siretNumber;

        return $this;
    }

    public function getVatNumber(): ?string
    {
        return $this->vatNumber;
    }

    public function setVatNumber(?string $vatNumber): self
    {
        $this->vatNumber = $vatNumber;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection|DeliveryAddress[]
     */
    public function getDeliveryAddress(): Collection
    {
        return $this->deliveryAddress;
    }

    public function addDeliveryAddress(DeliveryAddress $deliveryAddress): self
    {
        if (!$this->deliveryAddress->contains($deliveryAddress)) {
            $this->deliveryAddress[] = $deliveryAddress;
            $deliveryAddress->setBuyer($this);
        }

        return $this;
    }

    public function removeDeliveryAddress(DeliveryAddress $deliveryAddress): self
    {
        if ($this->deliveryAddress->contains($deliveryAddress)) {
            $this->deliveryAddress->removeElement($deliveryAddress);
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
    public function getSentOrder(): Collection
    {
        return $this->sentOrder;
    }

    public function addSentOrder(Order $sentOrder): self
    {
        if (!$this->sentOrder->contains($sentOrder)) {
            $this->sentOrder[] = $sentOrder;
            $sentOrder->setBuyer($this);
        }

        return $this;
    }

    public function removeSentOrder(Order $sentOrder): self
    {
        if ($this->sentOrder->contains($sentOrder)) {
            $this->sentOrder->removeElement($sentOrder);
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
        return $this->productsForSale;
    }

    public function addProductsForSale(Product $productsForSale): self
    {
        if (!$this->productsForSale->contains($productsForSale)) {
            $this->productsForSale[] = $productsForSale;
            $productsForSale->setSeller($this);
        }

        return $this;
    }

    public function removeProductsForSale(Product $productsForSale): self
    {
        if ($this->productsForSale->contains($productsForSale)) {
            $this->productsForSale->removeElement($productsForSale);
            // set the owning side to null (unless already changed)
            if ($productsForSale->getSeller() === $this) {
                $productsForSale->setSeller(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Order[]
     */
    public function getReceivedOrders(): Collection
    {
        return $this->receivedOrders;
    }

    public function addReceivedOrder(Order $receivedOrder): self
    {
        if (!$this->receivedOrders->contains($receivedOrder)) {
            $this->receivedOrders[] = $receivedOrder;
            $receivedOrder->addSeller($this);
        }

        return $this;
    }

    public function removeReceivedOrder(Order $receivedOrder): self
    {
        if ($this->receivedOrders->contains($receivedOrder)) {
            $this->receivedOrders->removeElement($receivedOrder);
            $receivedOrder->removeSeller($this);
        }

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }
}