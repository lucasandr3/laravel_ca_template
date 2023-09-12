<?php

namespace App\Domain\Interfaces\PregaoNovaLei;

interface GetDataItems
{
    public function getItemsByProcess(int $codProcess);
}
