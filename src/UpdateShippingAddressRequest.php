<?php

namespace App;

use App\Exceptions\ParametersException;

class UpdateShippingAddressRequest
{
    const FIELD__COUNTRY = 'country';
    const FIELD__CITY = 'city';
    const FIELD__ZIP_CODE = 'zipCode';
    const FIELD__STREET = 'street';
    const FIELD__DEFAULT = 'default';

    private array $allowedFields = [
        self::FIELD__COUNTRY,
        self::FIELD__CITY,
        self::FIELD__ZIP_CODE,
        self::FIELD__STREET,
        self::FIELD__DEFAULT
    ];

    private string $uuid;
    private ?string $country = null;
    private ?string $city = null;
    private ?string $zipCode = null;
    private ?string $street = null;
    private ?bool $default = null;

    public function __construct(array $arguments)
    {
        $arguments = array_values($arguments);

        if (!isset($arguments[0])) {
            throw new ParametersException('Address UUID should be present.');
        }

        $this->uuid = $arguments[0];

        unset($arguments[0]);

        if (!$arguments) {
            throw new ParametersException(
                sprintf(
                    'You should update at least one field. Allowed fields %s',
                    implode(', ', $this->allowedFields))
            );
        }

        foreach ($arguments as $argument) {
            if (strpos($argument, ':') === false) {
                throw new ParametersException('Parameter should be in format "field:value"');
            }

            $parts = explode(':', $argument);
            $field = $parts[0];
            $value = $parts[1];

            if (!in_array($field, $this->allowedFields)) {
                throw new ParametersException(
                    sprintf(
                        "Field %s is not allowed. Allowed fields %s",
                        $field,
                        implode(', ', $this->allowedFields))
                );
            }

            if ($field === static::FIELD__DEFAULT) {
                $value = (bool) $value;
            }

            $this->$field = $value;
        }
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function isDefault(): ?bool
    {
        return $this->default;
    }
}