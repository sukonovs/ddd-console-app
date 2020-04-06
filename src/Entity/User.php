<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DomainException;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="user")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    private UuidInterface $id;

    /**
     * @ORM\Column(type="string")
     */
    private string $firstName;

    /**
     * @ORM\Column(type="string")
     */
    private string $lastName;

    /**
     * @ORM\OneToMany(targetEntity="ShippingAddress", mappedBy="user")
     */
    private Collection $shippingAddresses;

    public function __construct(string $firstName, string $lastName)
    {
        $this->firstName = $this->validateFirstName($firstName);
        $this->lastName = $this->validateLastName($lastName);
        $this->shippingAddresses = new ArrayCollection();
    }

    private function validateFirstName(string $firstName): string
    {
        $minLength = 1;
        $maxLength = 255;

        if (mb_strlen($firstName) > $maxLength || mb_strlen($firstName) < $maxLength) {
            throw new DomainException(sprintf("First name should be between %s and %s characters", $minLength, $maxLength));
        }

        return $firstName;
    }

    private function validateLastName(string $lastName): string
    {
        $minLength = 1;
        $maxLength = 255;

        if (mb_strlen($lastName) > $maxLength || mb_strlen($lastName) < $maxLength) {
            throw new DomainException(sprintf("Last name should be between %s and %s characters", $minLength, $maxLength));
        }

        return $lastName;
    }

    public function addShippingAddress(ShippingAddress $address): void
    {
        $maxShippingAddresses = 3;

        if ($this->shippingAddresses->count() === 0) {
            $address->setDefault();
        }

        if ($this->shippingAddresses->count() === $maxShippingAddresses) {
            throw new DomainException(sprintf("Max shipping address count is %s", $maxShippingAddresses));
        }

        $this->shippingAddresses->add($address);
    }

    public function removeShippingAddress(ShippingAddress $address): void
    {
        $minShippingAddresses = 1;

        if (!$this->shippingAddresses->contains($address)) {
            throw new DomainException("Address does not belong to user");
        }

        if ($this->shippingAddresses->count() === $minShippingAddresses) {
            throw new DomainException(sprintf("Min shipping address count is %s", $minShippingAddresses));
        }

        if ($address->isDefault()) {
            throw new DomainException("Cannot remove default address");
        }

        $this->shippingAddresses->removeElement($address);
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return ShippingAddress[]|Collection
     */
    public function getShippingAddresses(): Collection
    {
        return $this->shippingAddresses;
    }
}