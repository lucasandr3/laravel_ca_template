<?php

namespace App\Domain\UseCases\PregaoNovaLei;

class CreateProcessRequestModel
{
    /**
     * @param array<mixed> $attributes
     */
    public function __construct(
        private array $attributes
    ) {
    }

    public function getName(): string
    {
        return $this->attributes['name'] ?? '';
    }

    public function getEmail(): string
    {
        return $this->attributes['email'] ?? '';
    }

    public function getPassword(): string
    {
        return $this->attributes['password'] ?? '';
    }
}
