<?php

namespace App\Domain\UseCases\Unidade;

use App\Domain\Interfaces\PregaoEletronico\ViewModel;
use App\Domain\UseCases\PregaoEletronico\CreateProcessResponseModel;

interface UnidadeOutput
{
    public function todasUnidades(string $unidades);

    public function unidade(string $unidade);

    public function notFoundResource(string $result);

    public function unableCreate(string $result);

    public function unableUpdated(string $result);
}
