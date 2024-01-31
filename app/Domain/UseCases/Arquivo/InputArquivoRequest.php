<?php

namespace App\Domain\UseCases\Arquivo;

class InputArquivoRequest
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

    public function getcodDocumento(): string
    {
        return $this->attributes['codDocumento'] ?? '';
    }

    public function getSequencialDocumento(): string
    {
        return $this->attributes['sequencial'] ?? '';
    }

    public function getReason(): string
    {
        return $this->attributes['reason'] ?? REASON_DEFAULT_REMOVE_FILE;
    }
}
