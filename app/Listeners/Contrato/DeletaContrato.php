<?php

namespace App\Listeners\Contrato;

use App\Events\Contrato\DeleteContratoEvent;
use App\Repositories\Contrato\ContratoRepository;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeletaContrato implements ShouldQueue
{
    public function __construct()
    {}

    public function handle(DeleteContratoEvent $event): void
    {
        (new ContratoRepository())->deletaContrato($event->codContrato);
    }
}
