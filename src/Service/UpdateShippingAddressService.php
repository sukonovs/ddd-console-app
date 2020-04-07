<?php

namespace App\Service;

use App\Entity\ShippingAddress;
use App\Entity\User;
use App\Exceptions\DomainException;
use App\UpdateShippingAddressRequest;
use Doctrine\ORM\EntityManager;

class UpdateShippingAddressService
{
    private EntityManager $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function execute(string $getUserUuid, UpdateShippingAddressRequest $serviceRequest): void
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

        $user->updateShippingAddress($address, $serviceRequest);
        $this->em->flush();
    }
}