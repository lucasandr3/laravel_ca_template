<?php

namespace App\Shared\Factories;

use App\Shared\Interfaces\ProcessToDatabaseFactory;
use Psr\Http\Message\ResponseInterface;

class ProcessToDatabase implements ProcessToDatabaseFactory
{
    public function make(array $process, ResponseInterface $response)
    {
        echo "<pre>"; var_dump($process, $response); echo "</pre>"; die;
    }
}
