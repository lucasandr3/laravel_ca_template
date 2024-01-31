<?php

namespace App\Listeners\Contrato;

use App\Events\Contrato\ContratoErrorEvent;

class ErroContrato
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
    public function handle(ContratoErrorEvent $event): void
    {
        //
    }
}
