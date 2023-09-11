<?php

namespace App\Infra\Database\Repositories\External\Process;

use App\Domain\Interfaces\PregaoNovaLei\GetDataProcess;
use App\Models\External\Administration;
use App\Models\External\Process;

class ExternalProcess implements GetDataProcess
{
    public function getProcessById(int $codProcess)
    {
        return Process::query()->where('id', $codProcess)->first();
    }
}
