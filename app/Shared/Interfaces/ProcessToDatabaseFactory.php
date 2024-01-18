<?php

namespace App\Shared\Interfaces;

use Psr\Http\Message\ResponseInterface;

interface ProcessToDatabaseFactory
{
    public function make(array $process, ResponseInterface $response);
}
