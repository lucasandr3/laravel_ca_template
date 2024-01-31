<?php

namespace App\Repositories\PregaoEletronico;

use App\Domain\Interfaces\PregaoEletronico\ProcessEntity;
use App\Domain\Interfaces\PregaoEletronico\ProcessRepository;
use App\Models\PregaoEletronico\Compra;
use App\Models\PregaoEletronico\Process;

class PregaoEletronicoRepository implements ProcessRepository
{
    public function exists(ProcessEntity $process): bool
    {
        return Process::query()->where([
            'cod_pregao' => $process->getCnpj(),
        ])->exists();

        return true;
    }

    public function create(ProcessEntity $process): ProcessEntity
    {
//        return User::create([
//            'name' => $user->getName(),
//            'email' => $user->getEmail(),
//            'password' => $password,
//        ]);

        return $process;
    }

    public function insert(array $data)
    {
        Compra::query()->insert($data);
    }

    public function atualizaCompra(int $codCompra, array $data)
    {
        Compra::query()->where('cod_pregao', '=', $codCompra)->update($data);
    }

    public function getCompra(int $codProcesso)
    {
        return Compra::query()->where('cod_pregao', '=', $codProcesso)->first();
    }

    public function removeCompra(int $codProcesso)
    {
        Compra::query()->where('cod_pregao', '=', $codProcesso)->delete();
    }
}
