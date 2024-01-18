<?php

namespace App\Domain\Interfaces\PregaoEletronico;

interface GetDataProcess
{
    public function getProcessById(int $codProcess);
}
