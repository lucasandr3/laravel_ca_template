<?php

namespace App\Listeners\Item;

use App\Events\Item\ExcluirItemEvent;
use App\Repositories\Item\ItemRepository;
use Illuminate\Contracts\Queue\ShouldQueue;

class ExcluirItensListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ExcluirItemEvent $event): void
    {
        (new ItemRepository())->removeItens($event->codCompra);
    }
}
