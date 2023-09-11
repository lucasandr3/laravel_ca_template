<?php

namespace App\Domain\UseCases\PregaoNovaLei;

use App\Domain\Interfaces\PregaoNovaLei\ViewModel;

interface CreateProcessInputPort
{
    public function createProcess(CreateProcessRequestModel $model): ViewModel;
}
