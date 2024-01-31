<?php

namespace App\Events\Contrato;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DeleteContratoEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public readonly int $codContrato;

    /**
     * Create a new event instance.
     */
    public function __construct(int $codContrato)
    {
        $this->codContrato = $codContrato;
    }
}
