<?php

namespace App\Service;

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

    }
}