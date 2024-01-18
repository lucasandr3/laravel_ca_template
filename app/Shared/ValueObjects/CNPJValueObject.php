<?php

namespace App\Shared\ValueObjects;

class CNPJValueObject
{
    public function __construct(private readonly string $documento)
    {}

    public function getValue(): string
    {
        return preg_replace("/[^0-9]/", '', $this->documento);
    }
}
