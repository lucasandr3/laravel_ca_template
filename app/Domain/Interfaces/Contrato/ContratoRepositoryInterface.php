<?php

namespace App\Domain\Interfaces\Contrato;

interface ContratoRepositoryInterface
{
    public function getContrato(int $codigoContrato, int $codProcesso);

    public function salvaContrato(array $contrato);

    public function deletaContrato(int $codContrato);
}
