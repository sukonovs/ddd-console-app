<?php

namespace App\ValueObjects;

use App\Exceptions\DomainException;

abstract class StringValue
{
    const VALUE_NAME = '';
    const MIN_LENGTH = 1;
    const MAX_LENGTH = 255;

    public function __construct(string $string)
    {
        if (!static::VALUE_NAME) {
            throw new \LogicException('VALUE_NAME should be defined');
        }

        if (mb_strlen($string) > static::MAX_LENGTH || mb_strlen($string) < static::MIN_LENGTH) {
            throw new DomainException(
                sprintf("%s should be between %s and %s characters", static::VALUE_NAME, static::MIN_LENGTH, static::MAX_LENGTH)
            );
        }
    }
}