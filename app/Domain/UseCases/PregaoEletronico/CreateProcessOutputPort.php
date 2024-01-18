<?php

namespace App\Domain\UseCases\PregaoEletronico;

use App\Domain\Interfaces\PregaoEletronico\ViewModel;

interface CreateProcessOutputPort
{
    public function processCreated(CreateProcessResponseModel $model): ViewModel;

    public function processAlreadyExists(array $error): ViewModel;

    public function unableToCreateProcess(CreateProcessResponseModel $model, \Throwable $e): ViewModel;

    public function deletedProcess(array $responde);

    public function unableToDeletedProcess(array $response, \Throwable $e): array;
}
