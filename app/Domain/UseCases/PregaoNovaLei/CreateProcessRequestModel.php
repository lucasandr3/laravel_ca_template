<?php

namespace App\Domain\UseCases\PregaoNovaLei;

class CreateProcessRequestModel
{
    /**
     * @param int $codProcess
     */
    public function __construct(private readonly int $codProcess) {}

    public function getCodProcess(): int
    {
        return $this->codProcess;
    }
}
