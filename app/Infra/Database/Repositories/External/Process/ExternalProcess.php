<?php

namespace App\Infra\Database\Repositories\External\Process;

use App\Domain\Interfaces\Dispensa\GetDataDispensa;
use App\Domain\Interfaces\PregaoEletronico\GetDataProcess;
use App\Models\External\Administration;
use App\Models\External\Process;

class ExternalProcess implements GetDataProcess, GetDataDispensa
{
    public function getProcessById(int $codProcess)
    {
        return Process::query()->where('id', $codProcess)->first();
    }
}
