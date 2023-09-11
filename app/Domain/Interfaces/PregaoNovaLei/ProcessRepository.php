<?php

namespace App\Domain\Interfaces\PregaoNovaLei;

use App\Domain\Interfaces\PregaoNovaLei\ProcessEntity;

interface ProcessRepository
{
    public function exists(ProcessEntity $user): bool;

    public function create(ProcessEntity $user): ProcessEntity;
}
