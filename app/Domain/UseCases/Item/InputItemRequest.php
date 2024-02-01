<?php

namespace App\Domain\UseCases\Item;

class InputItemRequest
{
    /**
     * @param array $attributes
     */
    public function __construct(
        private readonly array $attributes,
    ) {}

    public function getCodProcess(): int
    {
        return $this->attributes['codProcesso'] ?? '';
    }

    public function getCodItem(): string
    {
        return $this->attributes['codItem'] ?? '';
    }
}
