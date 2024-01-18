<?php

namespace App\Domain\UseCases\Unidade;

use App\Shared\ValueObjects\CNPJValueObject;

class InputRequestUnidade
{
    /**
     * @param array $attributes
     */
    public function __construct(
        private readonly array $attributes = [],
    ) {}

    public function getCodigoUnidade(): int
    {
        return $this->attributes['codigo'] ?? $this->attributes['codigoUnidade'] ?? 0;
    }

    public function getDocumento(): string
    {
        return $this->attributes['cnpj'] ?? (new CNPJValueObject($this->attributes['cnpj']))->getValue();
    }

    public function getDadosUnidade(): array
    {
        return [
            'codigoIBGE' => $this->attributes['codigoIBGE'],
            'codigoUnidade' => (int) $this->attributes['codigoUnidade'],
            'nomeUnidade' => $this->attributes['nomeUnidade']
        ];
    }
}
