<?php

namespace App\Domain\UseCases\Dispensa;

interface CreateDispensa
{
    public function createProcess(InputDispensa $input);

    public function deleteProcess(InputDispensa $input);
}
