<?php

namespace App\Shared\ValueObjects;

use Illuminate\Support\Carbon;

class DataAberturaPropostaValueObject
{
    private string $dataAbertura;

    public function __construct(string $value, int $typeProcess)
    {
        $this->make($value, $typeProcess);
    }

    private function make($value, $typeProcess): void
    {
        $instrument = instrument($typeProcess);
        $this->dataAbertura = $instrument === CONFIG_INSTRUMENTO_ATO ? '' : Carbon::parse($value)->format('Y-m-d\TH:i:s');
    }

    public function __toString(): string
    {
        return $this->dataAbertura;
    }
}
