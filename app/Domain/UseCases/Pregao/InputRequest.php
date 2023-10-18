<?php

namespace App\Domain\UseCases\Pregao;

class InputRequest
{
    /**
     * @param array $attributes
     * @param ?int $codProcess
     */
    public function __construct(
        private readonly array $attributes = [],
        private readonly ?int $codProcess = null
    ) {}

    public function getCodProcess(): int
    {
        return $this->codProcess;
    }

    public function getReason(): string
    {
        return $this->attributes['reason'] ?? REASON_DEFAULT_REMOVE_PURCHASE;
    }
}
