<?php

namespace App\Domain\Interfaces\PregaoNovaLei;

interface ProcessFactory
{
    /**
     * @param array<mixed> $attributes
     */
    public function make(array $attributes = []): ProcessEntity;
}
