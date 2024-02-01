<?php

namespace App\Domain\Interfaces\PregaoEletronico;

interface GetDataItems
{
    public function getItemsByProcess(int $codProcess);

    public function getItemsByID(int $codItem, int $codProcesso);

    public function getLoteDoItem(int $codProcesso, int $codLote);

    public function getVencedorDoLote(int $codVencedor);
}
