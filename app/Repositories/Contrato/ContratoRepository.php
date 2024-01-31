<?php

namespace App\Repositories\Contrato;

use App\Domain\Interfaces\Contrato\ContratoRepositoryInterface;
use App\Models\External\Administration;
use App\Models\External\Contract;


class ContratoRepository implements ContratoRepositoryInterface
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

    public function getContrato(int $codigoContrato, int $codigoProcesso)
    {
        return Contract::query()
            ->where('cod_pregao', $codigoProcesso)
            ->where('sequencial_contrato', $codigoContrato)
        ->first();
    }

    public function salvaContrato(array $contrato)
    {
        Contract::query()->insert($contrato);
    }

    public function deletaContrato(int $codContrato)
    {
        Contract::query()->find($codContrato)?->delete();
    }
}
