<?php

namespace App\Tests\Entity;

use App\Entity\ShippingAddress;
use App\Entity\User;
use App\Exceptions\DomainException;
use App\UpdateShippingAddressRequest;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testMaxShippingAddresses()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage("Max shipping address count is 3");

        $user = new User('Test', 'Test');
        $address = new ShippingAddress('Test', 'Test', 'Test', 'Test', $user);

        $user->addShippingAddress($address);
        $user->addShippingAddress($address);
        $user->addShippingAddress($address);
        $user->addShippingAddress($address);
    }

    public function testFirstAddressIsDefault()
    {
        $user = new User('Test', 'Test');
        $address1 = new ShippingAddress('Test', 'Test', 'Test', 'Test', $user);
        $address2 = new ShippingAddress('Test', 'Test', 'Test', 'Test', $user);

        $user->addShippingAddress($address1);
        $user->addShippingAddress($address2);

        $this->assertTrue($address1->isDefault());
        $this->assertFalse($address2->isDefault());
    }

    public function testCannotUpdateAnotherUserAddress()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage("Address does not belong to user");

        $user1 = new User('Test', 'Test');
        $user2 = new User('Test', 'Test');
        $address1 = new ShippingAddress('Test', 'Test', 'Test', 'Test', $user1);
        $address2 = new ShippingAddress('Test', 'Test', 'Test', 'Test', $user2);

        $updateRequest = new UpdateShippingAddressRequest(
            [
                "testUUID",
                "default:true"
            ]
        );

        $user1->updateShippingAddress($address2, $updateRequest);
    }

    public function testChangesDefaultAddress()
    {
        $user = new User('Test', 'Test');
        $address1 = new ShippingAddress('Test', 'Test', 'Test', 'Test', $user);
        $address2 = new ShippingAddress('Test', 'Test', 'Test', 'Test', $user);

        $user->addShippingAddress($address1);
        $user->addShippingAddress($address2);

        $updateRequest = new UpdateShippingAddressRequest(
            [
                "testUUID",
                "default:true"
            ]
        );

        $user->updateShippingAddress($address2, $updateRequest);

        $this->assertTrue($address2->isDefault());
        $this->assertFalse($address1->isDefault());
    }

    public function testCannotRemoveDefaultAddress()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage("Min shipping address count is 1");

        $user = new User('Test', 'Test');
        $address= new ShippingAddress('Test', 'Test', 'Test', 'Test', $user);
        $user->addShippingAddress($address);

        $user->removeShippingAddress($address);
    }
}