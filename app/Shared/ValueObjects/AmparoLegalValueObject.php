<?php

namespace App\Shared\ValueObjects;

use App\Models\External\Process;

class AmparoLegalValueObject
{
    private Process $process;

    public function __construct(Process $process)
    {
        $this->process = $process;
    }

    public function getValue(): string
    {
        return supportLegal($this->process);
    }
}
