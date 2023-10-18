<?php

namespace App\Shared\ValueObjects;

class DisputModeValueObject
{
    private string $typeProcess;
    private string $typeModel;

    public function __construct(string $typeProcess, string $typeModel)
    {
        $this->typeProcess = $typeProcess;
        $this->typeModel = $typeModel;
    }

    public function getValue(): int
    {
        return disputeMode($this->typeModel, $this->typeProcess);
    }
}
