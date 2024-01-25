<?php

namespace App\Shared\ValueObjects;

use NumberFormatter;

class MoneValueObject
{
    public function __construct(private readonly string $value)
    {}

    public function getValue(): string
    {
        return number_format($this->value, 4, '.', '');
    }
}
