<?php

namespace App\Repositories\Dispensa;

use App\Domain\Interfaces\Dispensa\DispensaEntity;
use App\Domain\Interfaces\Dispensa\DispensaRepositoryInterface;
use App\Models\Pregao\Process;

class DispensaRepository implements DispensaRepositoryInterface
{
    public function exists(DispensaEntity $process): bool
    {
        return Process::query()->where([
            'cod_pregao' => $process->getCnpj(),
        ])->exists();

        return true;
    }

    public function create(DispensaEntity $process): DispensaEntity
    {
//        return User::create([
//            'name' => $user->getName(),
//            'email' => $user->getEmail(),
//            'password' => $password,
//        ]);

        return $process;
    }
}
