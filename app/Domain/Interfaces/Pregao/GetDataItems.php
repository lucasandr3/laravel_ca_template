<?php

namespace App\Domain\Interfaces\Pregao;

interface GetDataItems
{
    public function getItemsByProcess(int $codProcess);
}
