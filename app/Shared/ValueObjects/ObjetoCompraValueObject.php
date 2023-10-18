<?php

namespace App\Shared\ValueObjects;

class ObjetoCompraValueObject
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function __toString(): string
    {
        return PREFIXO_FONTE . $this->value;
    }
}
