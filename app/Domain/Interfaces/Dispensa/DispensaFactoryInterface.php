<?php

namespace App\Domain\Interfaces\Dispensa;

interface DispensaFactoryInterface
{
    /**
     * @param array<mixed> $attributes
     */
    public function make(array $attributes = []): DispensaEntity;
}
