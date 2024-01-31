<?php

namespace App\Domain\Interfaces\PregaoEletronico;

interface ProcessRepository
{
    public function exists(ProcessEntity $user): bool;

    public function create(ProcessEntity $data): ProcessEntity;

    public function insert(array $data);

    public function getCompra(int $codProcesso);
}
