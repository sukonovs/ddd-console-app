<?php

namespace App\Components;

use App\Exceptions\DomainException;

trait StringValue
{
    public function validate(string $string, string $name): string
    {
        $minLength = 1;
        $maxLength = 255;

        if (mb_strlen($string) > $maxLength || mb_strlen($string) < $minLength) {
            throw new DomainException(sprintf("%s should be between %s and %s characters", $name, $minLength, $maxLength));
        }

        return $string;
    }
}