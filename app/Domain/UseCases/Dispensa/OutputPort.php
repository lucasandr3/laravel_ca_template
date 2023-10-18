<?php

namespace App\Domain\UseCases\Dispensa;

interface OutputPort
{
    public function processCreated(DispensaResponseModel $model);

    public function processAlreadyExists(array $error);

    public function unableToCreateProcess(DispensaResponseModel $model, \Throwable $e);
}
