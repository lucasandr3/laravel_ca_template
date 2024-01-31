<?php

namespace App\Domain\UseCases\PregaoEletronico;

use App\Domain\Interfaces\PregaoEletronico\ViewModel;

interface PregaoEletronicoOutput
{
    public function created();

    public function updated();

    public function deleted();

    public function notFoundResource();

    public function notFoundResourceInPncp();

    public function unableCreate(string $result);

    public function unableUpdated(string $result);

    public function unableDeleted(string $result);

    public function process(string $process);
}
