<?php

namespace App\Shared\Interfaces;

interface GetDataCompany
{
    public function getLanceVencedor(int $codLanceVencedor);

    public function getPorteFornecedor(int $codEnquadramento);
}
