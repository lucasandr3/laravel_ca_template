<?php

namespace App\Domain\Interfaces\PregaoEletronico;

interface GetDataItems
{
    public function getItemsByProcess(int $codProcess);
}
