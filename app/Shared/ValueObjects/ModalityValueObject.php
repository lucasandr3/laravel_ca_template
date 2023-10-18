<?php

namespace App\Shared\ValueObjects;

class ModalityValueObject
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function getValue(): int
    {
        return modality($this->value);
    }
}
