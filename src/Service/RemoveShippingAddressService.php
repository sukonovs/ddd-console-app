<?php

namespace App\Service;

use App\Components\ShippingAddressId;
use App\Entity\ShippingAddress;
use App\Entity\User;
use App\Exceptions\DomainException;
use App\RemoveShippingAddressRequest;
use Doctrine\ORM\EntityManager;

class RemoveShippingAddressService
{
    private EntityManager $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function execute(string $getUserUuid, RemoveShippingAddressRequest $serviceRequest): ShippingAddressId
    {
        $userRepo = $this->em->getRepository(User::class);
        /** @var User $user */
        $user = $userRepo->find($getUserUuid);

        if (!$user) {
            throw new DomainException('User not found.');
        }

        $addressRepo = $this->em->getRepository(ShippingAddress::class);
        /** @var ShippingAddress $address */
        $address = $addressRepo->find($serviceRequest->getUuid());

        if (!$address) {
            throw new DomainException('Address not found.');
        }

        $user->removeShippingAddress($address);
        $this->em->flush();

        return new ShippingAddressId($address);
    }
}