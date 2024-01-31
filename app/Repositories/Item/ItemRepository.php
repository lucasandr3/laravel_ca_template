<?php

namespace App\Repositories\Item;

use App\Models\Item\Item;

class ItemRepository
{
    public function salvaItens(array $itens)
    {
        Item::query()->insert($itens);
    }

    public function removeItens(int $codCompra)
    {
        Item::query()->where('cod_compra', '=', $codCompra)->delete();
    }
}
