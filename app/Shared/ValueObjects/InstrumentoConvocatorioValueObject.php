<?php

namespace App\Shared\ValueObjects;

class InstrumentoConvocatorioValueObject
{
    public string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function getValue(): int
    {
        return instrument($this->value);
    }
}
