<?php

namespace App\Shared\ValueObjects;

use App\Models\External\Process;

class SituacaoCompraValueObject
{
    private Process $process;

    public function __construct(Process $process)
    {
        $this->process = $process;
    }

    public function getValue(): int
    {
        return situationPurchase($this->process);
    }
}
