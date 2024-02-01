<?php

namespace App\Infra\Database\Repositories\External\Items;

use App\Domain\Interfaces\PregaoEletronico\GetDataItems;
use App\Models\External\Batch;
use App\Models\External\Company;
use App\Models\External\Item;

class ExternalItems implements GetDataItems
{
    public function getItemsByProcess(int $codProcess)
    {
        return Item::query()->where('cod_pregao', $codProcess)->get();
    }

    public function getItemsByID(int $codItem, int $codProcesso)
    {
        return Item::query()
            ->where('cod_pregao', '=', $codProcesso)
            ->where('id', '=', $codItem)
        ->first();
    }

    public function getLoteDoItem(int $codProcesso, int $codLote)
    {
        return Batch::query()
            ->where('cod_pregao', '=', $codProcesso)
            ->where('id', '=', $codLote)
        ->first();
    }

    public function getVencedorDoLote(int $codVencedor)
    {
        return Company::query()
            ->where('id', '=', $codVencedor)
        ->first();
    }
}
