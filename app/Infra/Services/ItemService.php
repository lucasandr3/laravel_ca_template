<?php

namespace App\Infra\Services;

use App\Models\External\Item;
use App\Shared\Interfaces\GetItemsProcess;

class ItemService implements GetItemsProcess
{
    public function getItemsByProcess(int $codProcess)
    {
        return Item::query()->where('cod_pregao', $codProcess)->get();
    }
}
