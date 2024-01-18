<?php

namespace App\Domain\UseCases\Orgao;

use App\Shared\ValueObjects\CNPJValueObject;

class InputRequestOrgao
{
    /**
     * @param array $attributes
     */
    public function __construct(
        private readonly array $attributes = [],
    ) {}

    public function getCodigoOrgao(): int
    {
        return $this->attributes['codigo'] ?? (int) $this->attributes['codigo'];
    }

    public function getDocumento(): string
    {
        return $this->attributes['cnpj'] ?? (new CNPJValueObject($this->attributes['cnpj']))->getValue();
    }

    public function getDadosOrgao(): array
    {
        return [
            'cnpj' => (new CNPJValueObject($this->attributes['cnpj']))->getValue(),
            'razaoSocial' => $this->attributes['razaoSocial'],
            'poderId' => $this->attributes['poderId'],
            'esferaId' => $this->attributes['esferaId']
        ];
    }
}
