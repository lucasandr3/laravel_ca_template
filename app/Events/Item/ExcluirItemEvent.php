<?php

namespace App\Events\Item;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ExcluirItemEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $codCompra;

    public function __construct($codCompra)
    {
        $this->codCompra = $codCompra;
    }
}
