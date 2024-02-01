<?php

namespace App\Repositories\Arquivo;

use App\Domain\Interfaces\Contrato\ArquivoRepository;
use App\Domain\Interfaces\PregaoEletronico\ProcessEntity;
use App\Domain\Interfaces\PregaoEletronico\ProcessRepository;
use App\Models\Arquivo\ArquivoCompra;
use App\Models\PregaoEletronico\Compra;
use App\Models\PregaoEletronico\Process;

class ArquivoCompraRepository implements ArquivoRepository
{
    public function insert(array $data)
    {
        ArquivoCompra::query()->insert($data);
    }

    public function atualizaCompra(int $codCompra, array $data)
    {
        Compra::query()->where('cod_pregao', '=', $codCompra)->update($data);
    }

    public function getDocument(int $codProcesso, int $codDocument)
    {
        return ArquivoCompra::query()
            ->where('cod_pregao', '=', $codProcesso)
            ->where('cod_edital', '=', $codDocument)
        ->first();
    }

    public function updateFile(array $data, int $codProcess, int $codDocument)
    {
        ArquivoCompra::query()
            ->where('cod_pregao', '=', $codProcess)
            ->where('cod_edital', '=', $codDocument)
        ->update($data);
    }

    public function removeCompra(int $codProcesso)
    {
        Compra::query()->where('cod_pregao', '=', $codProcesso)->delete();
    }

    public function exists(ProcessEntity $user): bool
    {
        // TODO: Implement exists() method.
    }

    public function create(ProcessEntity $data): ProcessEntity
    {
        // TODO: Implement create() method.
    }
}
