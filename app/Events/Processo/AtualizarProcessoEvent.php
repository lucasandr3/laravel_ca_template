<?php

namespace App\Events\Processo;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AtualizarProcessoEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $dadosCompra;

    public function __construct($dadosCompra)
    {
        $this->dadosCompra = $dadosCompra;
    }
}
