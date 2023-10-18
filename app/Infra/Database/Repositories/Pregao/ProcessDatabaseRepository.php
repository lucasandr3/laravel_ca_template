<?php

namespace App\Infra\Database\Repositories\Pregao;

use App\Domain\Interfaces\Pregao\ProcessEntity;
use App\Domain\Interfaces\Pregao\ProcessRepository;
use App\Models\External\Process;

class ProcessDatabaseRepository implements ProcessRepository
{
    public function exists(ProcessEntity $process): bool
    {
//        return User::where([
//            'name' => $user->getName(),
//            'email' => (string) $user->getEmail(),
//        ])->exists();

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
