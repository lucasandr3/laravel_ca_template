<?php

namespace App\Listeners\Processo;

use App\Events\Processo\ExcluirProcessoEvent;
use App\Repositories\PregaoEletronico\PregaoEletronicoRepository;
use Illuminate\Contracts\Queue\ShouldQueue;

class ExcluirProcessoListener implements ShouldQueue
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
    public function handle(ExcluirProcessoEvent $event): void
    {
        (new PregaoEletronicoRepository())->removeCompra($event->codProcesso);
    }
}
