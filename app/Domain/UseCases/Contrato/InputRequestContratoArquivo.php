<?php

namespace App\Domain\UseCases\Contrato;

use App\Shared\ValueObjects\CNPJValueObject;
use App\Shared\ValueObjects\DataContratoValueObject;
use App\Shared\ValueObjects\MoneValueObject;
use App\Shared\ValueObjects\ObjetoCompraValueObject;

class InputRequestContratoArquivo
{
    /**
     * @param array $attributes
     */
    public function __construct(
        private readonly array $attributes = [],
    ) {}

    public function getCodProcesso(): int
    {
        return $this->attributes['processo'];
    }

    public function getSequencialContrato(): int
    {
        return $this->attributes['sequencialContrato'];
    }

    public function getDados(): array
    {
        return [
            'codProcesso' => $this->getCodProcesso(),
            'sequencialContrato' => $this->getSequencialContrato(),
        ];
    }
}
