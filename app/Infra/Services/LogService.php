<?php

namespace App\Infra\Services;

use App\Models\Dispensa\Process;
use Illuminate\Support\Fluent;

class LogService
{
    public static function saveLogProcess(Process $process, $exception = null)
    {
        $array = [
            'message' => 'teste',
            'code' => 200
        ];

        $array = new Fluent($array);

        echo "<pre>"; var_dump($array); echo "</pre>"; die;

        $body = $process->toObject();

        echo "<pre>"; var_dump($body, $exception); echo "</pre>"; die;
    }
}
