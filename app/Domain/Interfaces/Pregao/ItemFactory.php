<?php

namespace App\Domain\Interfaces\Pregao;

use Illuminate\Database\Eloquent\Collection;

interface ItemFactory
{
    /**
     * @param array<mixed> $attributes
     */
    public function make(Collection $attributes = null): ItemEntity;
}
