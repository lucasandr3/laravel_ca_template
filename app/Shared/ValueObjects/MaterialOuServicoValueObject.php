<?php

namespace App\Shared\ValueObjects;

use App\Models\External\Item;

class MaterialOuServicoValueObject
{
    private Item $item;

    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    public function getValue(): string
    {
        if($this->item->process()->tipo_processo != CONFIG_TIPO_LEILAO_ELETRONICO){
            return (isMaterialTypeImp($this->item->process()->cod_suprimento) ? CONFIG_SUPRIMENTO_MATERIAL : CONFIG_SUPRIMENTO_SERVICO);
        }
        return CONFIG_SUPRIMENTO_MATERIAL;
    }
}
