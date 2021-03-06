<?php

namespace App\Entity;

use App\Components\StringValue;
use App\Exceptions\DomainException;
use App\UpdateShippingAddressRequest;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity()
 * @ORM\Table(name="user")
 */
class User
{
    use StringValue;

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
        $this->firstName = $this->validate($firstName, 'firstName');
        $this->lastName = $this->validate($lastName, 'lastName');
        $this->shippingAddresses = new ArrayCollection();
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

    public function updateShippingAddress(ShippingAddress $address, UpdateShippingAddressRequest $request): void
    {
        $key = $this->shippingAddresses->indexOf($address);

        if (!$key) {
            throw new DomainException("Address does not belong to user");
        }

        if ($request->isDefault() === true) {
            $this->shippingAddresses->map(function (ShippingAddress $address) {
                $address->removeDefault();
            });
        }

        /** @var ShippingAddress $address */
        $address = $this->shippingAddresses->get($key);
        $address->update($request);
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }
}