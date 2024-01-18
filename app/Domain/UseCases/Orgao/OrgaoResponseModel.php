<?php

namespace App\Domain\UseCases\Orgao;

use App\Domain\Interfaces\PregaoEletronico\ProcessEntity;

class OrgaoResponseModel
{
    public function __construct(private ProcessEntity $process) {}

    public function getProcess(): ProcessEntity
    {
        return $this->process;
    }
}
