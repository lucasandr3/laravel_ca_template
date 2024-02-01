<?php

namespace App\Events\Item;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AtualizaItemEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $dadosItem;

    public function __construct($dadosItem)
    {
        $this->dadosItem = $dadosItem;
    }
}
