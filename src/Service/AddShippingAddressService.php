<?php

namespace App\Service;

use App\AddShippingAddressRequest;
use App\Components\ShippingAddressId;
use App\Entity\ShippingAddress;
use App\Entity\User;
use App\Exceptions\DomainException;
use Doctrine\ORM\EntityManager;

class AddShippingAddressService
{
    private EntityManager $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function execute(string $getUserUuid, AddShippingAddressRequest $serviceRequest): ShippingAddressId
    {
        $userRepo = $this->em->getRepository(User::class);
        /** @var User $user */
        $user = $userRepo->find($getUserUuid);

        if (!$user) {
            throw new DomainException('User not found.');
        }

        $address = new ShippingAddress(
            $serviceRequest->getCountry(),
            $serviceRequest->getCity(),
            $serviceRequest->getZipCode(),
            $serviceRequest->getStreet()
        );

        $user->addShippingAddress($address);

        $this->em->persist($address);
        $this->em->flush();

        return new ShippingAddressId($address);
    }
}