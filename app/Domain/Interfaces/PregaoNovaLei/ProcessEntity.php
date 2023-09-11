<?php

namespace App\Domain\Interfaces\PregaoNovaLei;

interface ProcessEntity
{
    public function getName(): string;

    public function setName(string $name): void;

    public function getEmail();

    public function setEmail($email): void;

    public function getPassword();

    public function setPassword(): void;
}
