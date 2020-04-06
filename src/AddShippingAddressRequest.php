<?php

namespace App;

use App\Exceptions\ParametersException;

class AddShippingAddressRequest
{
    private string $country;
    private string $city;
    private string $zipCode;
    private string $street;

    public function __construct(array $arguments)
    {
        $argumentCount = 4;

        $arguments = array_values($arguments);

        if (count($arguments) !== $argumentCount) {
            throw new ParametersException(
                sprintf("Invalid count of arguments %s (country, city, zipCode, street)", $argumentCount)
            );
        }
        $this->country = $arguments[0];
        $this->city = $arguments[1];
        $this->zipCode = $arguments[2];
        $this->street = $arguments[3];
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    public function getStreet(): string
    {
        return $this->street;
    }
}