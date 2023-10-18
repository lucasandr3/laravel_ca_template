<?php

namespace App\Domain\Interfaces\Dispensa;

interface DispensaRepositoryInterface
{
    public function exists(DispensaEntity $user): bool;

    public function create(DispensaEntity $data): DispensaEntity;
}
