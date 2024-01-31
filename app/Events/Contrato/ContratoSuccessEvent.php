<?php

namespace App\Events\Contrato;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ContratoSuccessEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public array $contrato;
    public array $location;

    public function __construct($compra, $location)
    {
        $this->contrato = $compra;
        $this->location = $location;
    }
}
