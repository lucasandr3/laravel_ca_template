<?php

namespace App\Domain\UseCases\Unidade;

use App\Domain\Interfaces\PregaoEletronico\ProcessEntity;

class UnidadeResponseModel
{
    public function __construct(private ProcessEntity $process) {}

    public function getProcess(): ProcessEntity
    {
        return $this->process;
    }
}
