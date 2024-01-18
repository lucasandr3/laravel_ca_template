<?php

namespace App\Domain\Interfaces\PregaoEletronico;

use App\Domain\Interfaces\PregaoEletronico\ProcessEntity;

interface ProcessRepository
{
    public function exists(ProcessEntity $user): bool;

    public function create(ProcessEntity $data): ProcessEntity;
}
