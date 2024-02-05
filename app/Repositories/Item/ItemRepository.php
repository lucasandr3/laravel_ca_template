<?php

namespace App\Repositories\Item;

use App\Application\Models\Bid;
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

    public function updateOneItem(array $data, $codProcesso, $codItem)
    {
        Item::query()
            ->where('cod_pregao', '=', $codProcesso)
            ->where('numero_item', '=', $codItem)
        ->update($data);
    }

    public function getItemById(int $numeroItem): Item
    {
        return Item::query()->where('numero_item', '=', $numeroItem)->first();
    }

    public function getLanceVencedor($codLanceVencedor)
    {
        return Bid::query()->where('id', '=', $codLanceVencedor)->first();
    }
}
