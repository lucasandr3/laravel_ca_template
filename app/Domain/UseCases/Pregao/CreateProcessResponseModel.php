<?php

namespace App\Domain\UseCases\Pregao;

use App\Domain\Interfaces\Pregao\ProcessEntity;

class CreateProcessResponseModel
{
    public function __construct(private ProcessEntity $process) {}

    public function getProcess(): ProcessEntity
    {
        return $this->process;
    }
}
