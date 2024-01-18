<?php

namespace App\Domain\Interfaces\PregaoEletronico;

use Illuminate\Database\Eloquent\Collection;

interface ItemFactory
{
    /**
     * @param array<mixed> $attributes
     */
    public function make(Collection $attributes = null): ItemEntity;
}
