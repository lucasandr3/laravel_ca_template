<?php

namespace App\Infra\Database\Repositories\Dispensa;

use App\Domain\Interfaces\Dispensa\DispensaEntity;
use App\Domain\Interfaces\Dispensa\DispensaRepositoryInterface;

class DispensaDatabaseRepository implements DispensaRepositoryInterface
{
    public function exists(DispensaEntity $process): bool
    {
//        return User::where([
//            'name' => $user->getName(),
//            'email' => (string) $user->getEmail(),
//        ])->exists();

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
