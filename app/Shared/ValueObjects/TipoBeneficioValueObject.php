<?php

namespace App\Shared\ValueObjects;


use App\Models\External\Item;

class TipoBeneficioValueObject
{
    private Item $item;

    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    public function getValue(): int
    {
        if($this->item->process()->tipo_processo != CONFIG_TIPO_LEILAO_ELETRONICO){
            return (isExclusiveMeImp($this->item->meepp) ? CONFIG_BENEFICIO_COTAEXCLUSIVAMEEP : CONFIG_BENEFICIO_SEMBENEFICIO);
        }
        return CONFIG_PNCP_NAOSEAPLICA;
    }
}
