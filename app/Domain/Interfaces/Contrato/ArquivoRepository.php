<?php

namespace App\Domain\Interfaces\Contrato;

use App\Domain\Interfaces\PregaoEletronico\ProcessEntity;

interface ArquivoRepository
{
    public function exists(ProcessEntity $user): bool;

    public function create(ProcessEntity $data): ProcessEntity;

    public function insert(array $data);

    public function getDocument(int $codProcesso, int $codDocument);

    public function updateFile(array $data, int $codProcess, int $codDocument);
}
