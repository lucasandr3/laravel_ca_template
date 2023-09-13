<?php

namespace App\Factories\PregaoNovaLei;

use App\Domain\Interfaces\PregaoNovaLei\ProcessEntity;
use App\Domain\Interfaces\PregaoNovaLei\ProcessFactory;
use App\Models\PregaoNovaLei\Process;

class ProcessModelFactory implements ProcessFactory
{
    public function make(array $attributes = []): ProcessEntity
    {

//        if (isset($attributes['email']) && is_string($attributes['email'])) {
//            $attributes['email'] = new EmailValueObject($attributes['email']);
//        }
//
//        if (isset($attributes['password']) && is_string($attributes['password'])) {
//            $attributes['password'] = new PasswordValueObject($attributes['password']);
//        }

        return new Process($attributes);
    }
}
