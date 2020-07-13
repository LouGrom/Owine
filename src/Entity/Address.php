<?php

namespace App\Entity;

use App\Repository\AddressRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * @ORM\Entity(repositoryClass=AddressRepository::class)
 */
class Address
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $lastname;

    /**
     * @Groups({"searchable"})
     * @ORM\Column(type="string", length=50)
     */
    private $street;

    /**
     * @Groups({"searchable"})
     * @ORM\Column(type="string", length=10)
     */
    private $zipCode;

    /**
     * @Groups({"searchable"})
     * @ORM\Column(type="string", length=50)
     */
    private $city;

    /**
     * @Groups({"searchable"})
     * @ORM\Column(type="string", length=50)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $phoneNumber;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="address")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="array")
     */
    private $type = [];

    /** 
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $province;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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

    public function getType(): ?array
    {
        return $this->type;
    }

    public function setType(array $type): self
    {
        $this->type = $type;

        return $this;
    }

    // Méthode permettant de transformer les objets address en format JSON afin de pouvoir exploiter les données saisies dans le cadre de l'utilisation de l'API d'Algolia pour faire des recherches sur les données de l'application
    public function normalize(NormalizerInterface $serializer, $format = null, array $context = []): array
    {
        return [
            'street' => $this->getStreet(),
            'zipCode' => $this->getZipCode(),
            'city' => $this->getCity(),
            'country' => $this->getCountry(),

            // Reuse the $serializer
            'street' => $serializer->normalize($this->getStreet(), $format, $context),
            'zipCode' => $serializer->normalize($this->getZipCode(), $format, $context),
            'city' => $serializer->normalize($this->getCity(), $format, $context),
            'country' => $serializer->normalize($this->getCountry(), $format, $context),
        ];
    }
    public function getProvince(): ?string
    {
        return $this->province;
    }

    public function setProvince(?string $province): self
    {
        $this->province = $province;

        return $this;
    }
}
