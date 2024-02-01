<?php

namespace App\Listeners\Arquivo;

use App\Events\Arquivo\AtualizaArquivoEvent;
use App\Repositories\Arquivo\ArquivoCompraRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AtualizaArquivoListener implements ShouldQueue
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
    public function handle(AtualizaArquivoEvent $event): void
    {
        $codProcess = $event->dadosArquivo->codProcess;
        $codDocument = $event->dadosArquivo->codDocument;

        $dataToUpdate = $this->retornaDados($event->dadosArquivo);
        (new ArquivoCompraRepository())->updateFile($dataToUpdate, $codProcess, $codDocument);
    }

    private function retornaDados($dadosArquivo): array
    {
        return [
            'bol_excluido' => 1,
            'motivo' => $dadosArquivo->reason
        ];
    }
}
