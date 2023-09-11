<?php

namespace App\Repositories\PregaoNovaLei;

use App\Domain\Interfaces\PregaoNovaLei\ProcessEntity;
use App\Domain\Interfaces\PregaoNovaLei\ProcessRepository;

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
