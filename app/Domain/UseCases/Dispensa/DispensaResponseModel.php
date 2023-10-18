<?php

namespace App\Domain\UseCases\Dispensa;

use App\Domain\Interfaces\Dispensa\DispensaEntity;

class DispensaResponseModel
{
    public function __construct(private DispensaEntity $dispensa) {}

    public function getProcess(): DispensaEntity
    {
        return $this->dispensa;
    }
}
