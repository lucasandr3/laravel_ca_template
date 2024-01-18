<?php

namespace App\Domain\UseCases\PregaoEletronico;

use App\Domain\Interfaces\PregaoEletronico\ViewModel;

interface CreateProcessInputPort
{
    public function createProcess(InputRequest $input): ViewModel;
}
