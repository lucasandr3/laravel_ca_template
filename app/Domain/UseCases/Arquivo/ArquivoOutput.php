<?php

namespace App\Domain\UseCases\Arquivo;

use App\Domain\Interfaces\PregaoEletronico\ViewModel;
use App\Domain\UseCases\PregaoEletronico\CreateProcessResponseModel;

interface ArquivoOutput
{
    public function notFoundResource(string $result);

    public function unableUploaded(string $result);

    public function unableDeleted(string $result);

    public function success();

    public function deleted();
}
