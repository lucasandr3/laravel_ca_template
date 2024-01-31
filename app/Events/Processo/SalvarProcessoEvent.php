<?php

namespace App\Events\Processo;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Fluent;

class SalvarProcessoEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Fluent $dadosCompra;

    /**
     * Create a new event instance.
     */
    public function __construct($dadosCompra)
    {
        $this->dadosCompra = $dadosCompra;
    }
}
