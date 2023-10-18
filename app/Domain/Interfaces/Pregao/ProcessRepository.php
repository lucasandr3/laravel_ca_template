<?php

namespace App\Domain\Interfaces\Pregao;

use App\Domain\Interfaces\Pregao\ProcessEntity;

interface ProcessRepository
{
    public function exists(ProcessEntity $user): bool;

    public function create(ProcessEntity $data): ProcessEntity;
}
