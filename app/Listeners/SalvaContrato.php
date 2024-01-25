<?php

namespace App\Listeners;

use App\Events\Contrato\ContratoSuccessEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SalvaContrato implements ShouldQueue
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
    public function handle(ContratoSuccessEvent $event): void
    {
        $contrato = $event->contrato;
    }
}
