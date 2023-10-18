<?php

namespace App\Domain\Interfaces\Pregao;

interface ProcessFactory
{
    /**
     * @param array<mixed> $attributes
     */
    public function make(array $attributes = []): ProcessEntity;
}
