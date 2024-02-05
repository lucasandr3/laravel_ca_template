<?php

namespace App\Repositories\Fornecedor;

use App\Models\External\Bid;
use App\Models\External\Framing;
use App\Models\Item\Item;
use App\Shared\Interfaces\GetDataCompany;

class FornecedorRepository implements GetDataCompany
{

    public function getPorteFornecedor(int $codEnquadramento)
    {
        return Framing::query()->where('id', '=', $codEnquadramento)->first();
    }

    public function getLanceVencedor($codLanceVencedor)
    {
        return Bid::query()->where('id', '=', $codLanceVencedor)->first();
    }
}
