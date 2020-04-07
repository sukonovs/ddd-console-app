<?php

namespace App\Entity;

use App\Components\StringValue;
use App\UpdateShippingAddressRequest;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity()
 * @ORM\Table(name="shipping_address")
 */
class ShippingAddress
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
    private string $country;

    /**
     * @ORM\Column(type="string")
     */
    private string $city;

    /**
     * @ORM\Column(type="string")
     */
    private string $zipCode;

    /**
     * @ORM\Column(type="string")
     */
    private string $street;

    /**
     * @ORM\Column(type="boolean", name="is_default")
     */
    private bool $default = false;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="shippingAddresses")
     */
    protected User $user;

    public function __construct(string $country, string $city, string $zipCode, string $street, User $user)
    {
        $this->country = $this->validate($country, 'country');
        $this->city = $this->validate($city, 'city');
        $this->zipCode = $this->validate($zipCode, 'zipCode');
        $this->street = $this->validate($street, 'street');
        $this->user = $user;
    }

    public function setDefault()
    {
        $this->default = true;
    }

    public function removeDefault()
    {
        $this->default = false;
    }

    /**
     * @return bool
     */
    public function isDefault(): bool
    {
        return $this->default;
    }

    /**
     * @return UuidInterface
     */
    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function update(UpdateShippingAddressRequest $serviceRequest)
    {
        if ($serviceRequest->isDefault() !== null) {
            $this->default = $serviceRequest->isDefault();
        }

        if ($serviceRequest->getStreet() !== null) {
            $this->street = $this->validate($serviceRequest->getStreet(), 'street');
        }

        if ($serviceRequest->getZipCode() !== null) {
            $this->zipCode = $this->validate($serviceRequest->getZipCode(), 'zipCode');
        }

        if ($serviceRequest->getCity() !== null) {
            $this->city = $this->validate($serviceRequest->getCity(), 'city');
        }

        if ($serviceRequest->getCountry() !== null) {
            $this->country = $this->validate($serviceRequest->getCountry(), 'country');
        }
    }
}