<?php

namespace App\Infra\Database\Repositories\External\Items;

use App\Domain\Interfaces\PregaoEletronico\GetDataItems;
use App\Models\External\Item;

class ExternalItems implements GetDataItems
{
    public function getItemsByProcess(int $codProcess)
    {
        return Item::query()->where('cod_pregao', $codProcess)->get();
    }
}
