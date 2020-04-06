<?php

namespace App;

use App\Exceptions\ParametersException;

class RemoveShippingAddressRequest
{
    private string $uuid;

    public function __construct(array $arguments)
    {
        $arguments = array_values($arguments);

        if (!isset($arguments[0])) {
            throw new ParametersException('Address UUID should be present.');
        }

        $this->uuid = $arguments[0];
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }
}