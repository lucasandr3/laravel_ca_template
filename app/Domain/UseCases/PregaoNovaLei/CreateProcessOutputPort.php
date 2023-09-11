<?php

namespace App\Domain\UseCases\PregaoNovaLei;

use App\Domain\Interfaces\PregaoNovaLei\ViewModel;

interface CreateProcessOutputPort
{
    public function processCreated(CreateProcessResponseModel $model): ViewModel;

    public function processAlreadyExists(CreateProcessResponseModel $model): ViewModel;

    public function unableToCreateProcess(CreateProcessResponseModel $model, \Throwable $e): ViewModel;
}
