<?php

namespace App\Events\Item;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SalvarItemEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $dadosCompra;

    public function __construct($dadosCompra)
    {
        $this->dadosCompra = $dadosCompra;
    }
}
