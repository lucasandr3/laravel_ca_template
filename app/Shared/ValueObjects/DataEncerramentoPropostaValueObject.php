<?php

namespace App\Shared\ValueObjects;

use Illuminate\Support\Carbon;

class DataEncerramentoPropostaValueObject
{
    private string $dataEncerramento;

    public function __construct(string $value, int $typeProcess)
    {
        $this->make($value, $typeProcess);
    }

    private function make($value, $typeProcess): void
    {
        $instrument = instrument($typeProcess);
        $this->dataEncerramento = $instrument === CONFIG_INSTRUMENTO_ATO ? '' : Carbon::parse($value)->format('Y-m-d\TH:i:s');
    }

    public function __toString(): string
    {
        return $this->dataEncerramento;
    }
}
