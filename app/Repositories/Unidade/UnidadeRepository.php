<?php

namespace App\Repositories\Unidade;

use App\Domain\Interfaces\PregaoEletronico\ProcessEntity;
use App\Domain\Interfaces\Unidade\UnidadeRepositoryInterface;
use App\Models\External\Administration;
use App\Models\PregaoEletronico\Process;

class UnidadeRepository implements UnidadeRepositoryInterface
{
//    public function exists(ProcessEntity $process): bool
//    {
//        return Process::query()->where([
//            'cod_pregao' => $process->getCnpj(),
//        ])->exists();
//
//        return true;
//    }
//
//    public function create(ProcessEntity $process): ProcessEntity
//    {
////        return User::create([
////            'name' => $user->getName(),
////            'email' => $user->getEmail(),
////            'password' => $password,
////        ]);
//
//        return $process;
//    }

    public function getUnidade(int $codigoUnidade)
    {
        return Administration::query()->find($codigoUnidade);
    }
}
