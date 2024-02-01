<?php

namespace App\Infra\Database\Repositories\External\Process;

use App\Domain\Interfaces\Dispensa\GetDataDispensa;
use App\Domain\Interfaces\PregaoEletronico\GetDataProcess;
use App\Models\External\Administration;
use App\Models\External\Process;
use App\Models\External\ProcessExtractLog;

class ExternalProcess implements GetDataProcess, GetDataDispensa
{
    public function getProcessById(int $codProcess)
    {
        return Process::query()->where('id', $codProcess)->first();
    }

    public function getHomologationDate(int $codProcesso, int $tipoExtrato)
    {
        return ProcessExtractLog::query()
            ->where('cod_pregao', '=', $codProcesso)
            ->where('cod_tipo_alteracao', '=', $tipoExtrato)
            ->orderBy('id', 'DESC')
        ->first();
    }
}
