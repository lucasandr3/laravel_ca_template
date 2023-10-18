<?php

namespace App\Infra\Services;

use App\Models\External\Process;
use App\Shared\Interfaces\GetDataProcess;

class ProcessService implements GetDataProcess
{
    public function getProcessById(int $codProcess)
    {
        return Process::query()->find($codProcess);
    }
}
