<?php


namespace App\Components;


use App\Entity\ShippingAddress;
use Ramsey\Uuid\UuidInterface;

class ShippingAddressId
{
    /**
     * @var UuidInterface
     */
    private UuidInterface $id;

    public function __construct(ShippingAddress $address)
    {
        $this->id = $address->getId();
    }

    public function __toString()
    {
        return $this->id->toString();
    }
}