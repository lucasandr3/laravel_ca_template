<?php

namespace App\Domain\Interfaces\PregaoEletronico;

interface ProcessFactory
{
    /**
     * @param array<mixed> $attributes
     */
    public function make(array $attributes = []): ProcessEntity;
}
