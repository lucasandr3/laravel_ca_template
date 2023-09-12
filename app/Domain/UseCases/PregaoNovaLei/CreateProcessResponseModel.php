<?php

namespace App\Domain\UseCases\PregaoNovaLei;

use App\Domain\Interfaces\PregaoNovaLei\ProcessEntity;

class CreateProcessResponseModel
{
    public function __construct(private ProcessEntity $process) {}

    public function getProcess(): ProcessEntity
    {
        return $this->process;
    }
}
