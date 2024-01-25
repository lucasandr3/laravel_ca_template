<?php

namespace App\Shared\ValueObjects;

use Illuminate\Support\Carbon;

class DataContratoValueObject
{
    private string $formatedData;

    public function __construct(string $value)
    {
        $this->make($value);
    }

    private function make($value): void
    {
        $dateForCarbonParsed = Carbon::createFromFormat('d/m/Y', $value);
        $this->formatedData = Carbon::parse($dateForCarbonParsed)->format('Y-m-d');
    }

    public function __toString(): string
    {
        return $this->formatedData;
    }
}
