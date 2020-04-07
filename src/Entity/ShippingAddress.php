<?php

namespace App\Entity;

use App\Components\StringValue;
use App\UpdateShippingAddressRequest;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ShippingAddressRepository")
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
     * @ORM\Column(type="boolean")
     */
    private bool $default;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="shippingAddresses")
     */
    protected User $user;

    public function __construct(string $country, string $city, string $zipCode, string $street)
    {
        $this->country = $this->validate($country, 'country');
        $this->city = $this->validate($city, 'city');
        $this->zipCode = $this->validate($zipCode, 'zipCode');
        $this->street = $this->validate($street, 'street');
    }

    public function setDefault()
    {
        $this->default = true;
    }

    /**
     * @return bool
     */
    public function isDefault(): bool
    {
        return $this->default;
    }
}