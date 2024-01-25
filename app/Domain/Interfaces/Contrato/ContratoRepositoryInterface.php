<?php

namespace App\Domain\Interfaces\Contrato;

interface ContratoRepositoryInterface
{
    public function getContrato(int $codigoContrato, int $codProcesso);
}
