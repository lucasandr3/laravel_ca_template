<?php

namespace App\Domain\Interfaces\PregaoEletronico;

interface GetDataProcess
{
    public function getProcessById(int $codProcess);

    public function getHomologationDate(int $codProcesso, int $tipoExtrato);
}
