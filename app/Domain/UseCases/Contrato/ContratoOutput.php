<?php

namespace App\Domain\UseCases\Contrato;

use App\Domain\Interfaces\PregaoEletronico\ViewModel;
use App\Domain\UseCases\PregaoEletronico\CreateProcessResponseModel;

interface ContratoOutput
{
    public function contrato(string $contrato);

    public function deleted();

    public function notFoundResource();

    public function unableCreate(string $result);

    public function unableUpdated(string $result);

    public function unableDeleted(string $result);
}
