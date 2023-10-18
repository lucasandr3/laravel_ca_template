<?php

namespace App\Domain\UseCases\Pregao;

use App\Domain\Interfaces\Pregao\ViewModel;

interface CreateProcessInputPort
{
    public function createProcess(InputRequest $input): ViewModel;
}
