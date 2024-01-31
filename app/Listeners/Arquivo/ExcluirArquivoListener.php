<?php

namespace App\Listeners\Arquivo;

use App\Events\Arquivo\ExcluirArquivoEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ExcluirArquivoListener implements ShouldQueue
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
    public function handle(ExcluirArquivoEvent $event): void
    {
        //
    }
}
