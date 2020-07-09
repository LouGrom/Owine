<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
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
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @Assert\Length(
     *      min = 6,
     *      minMessage = "Votre mot de passe doit être long d'au moins {{ limit }} caractères",
     *      allowEmptyString = false
     * )
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=30)
     */
    private $firstname;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=30)
     */
    private $lastname;

    /**
     * @ORM\OneToMany(targetEntity=Address::class, mappedBy="user")
     * 
     */
    private $address;

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
     * @ORM\OneToMany(targetEntity=Cart::class, mappedBy="user")
     */
    private $carts;

    /**
     * @ORM\ManyToOne(targetEntity=Company::class, inversedBy="seller")
     */
    private $company;

    // /**
    //  * @ORM\Column(type="boolean")
    //  */
    // private $isVerified = false;

    public function __construct()
    {
        $this->address = new ArrayCollection();
        $this->sentOrder = new ArrayCollection();
        $this->productsForSale = new ArrayCollection();
        $this->receivedOrders = new ArrayCollection();
        $this->carts = new ArrayCollection();
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
     * @return Collection|Address[]
     */
    public function getAddress(): Collection
    {
        return $this->address;
    }

    public function addAddress(Address $address): self
    {
        if (!$this->address->contains($address)) {
            $this->address[] = $address;
            $address->setUser($this);
        }

        return $this;
    }

    public function setAddress(Address $address): self
    {
        $this->address[] = $address;

        return $this;
    }

    public function removeAddress(Address $address): self
    {
        if ($this->address->contains($address)) {
            $this->address->removeElement($address);
            // set the owning side to null (unless already changed)
            if ($address->getUser() === $this) {
                $address->setUser(null);
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

    // public function isVerified(): bool
    // {
    //     return $this->isVerified;
    // }

    // public function setIsVerified(bool $isVerified): self
    // {
    //     $this->isVerified = $isVerified;

    //     return $this;
    // }

    /**
     * @return Collection|Cart[]
     */
    public function getCarts(): Collection
    {
        return $this->carts;
    }

    public function addCart(Cart $cart): self
    {
        if (!$this->carts->contains($cart)) {
            $this->carts[] = $cart;
            $cart->setUser($this);
        }

        return $this;
    }

    public function removeCart(Cart $cart): self
    {
        if ($this->carts->contains($cart)) {
            $this->carts->removeElement($cart);
            // set the owning side to null (unless already changed)
            if ($cart->getUser() === $this) {
                $cart->setUser(null);
            }
        }

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }
}