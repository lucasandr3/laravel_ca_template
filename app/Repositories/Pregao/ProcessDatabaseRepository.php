<?php

namespace App\Repositories\Pregao;

use App\Domain\Interfaces\Pregao\ProcessEntity;
use App\Domain\Interfaces\Pregao\ProcessRepository;
use App\Models\Pregao\Process;

class ProcessDatabaseRepository implements ProcessRepository
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
}
