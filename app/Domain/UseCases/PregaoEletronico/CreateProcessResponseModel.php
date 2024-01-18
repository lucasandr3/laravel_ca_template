<?php

namespace App\Domain\UseCases\PregaoEletronico;

use App\Domain\Interfaces\PregaoEletronico\ProcessEntity;

class CreateProcessResponseModel
{
    public function __construct(private ProcessEntity $process) {}

    public function getProcess(): ProcessEntity
    {
        return $this->process;
    }
}
