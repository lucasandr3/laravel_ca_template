<?php

namespace App\Listeners\Arquivo;

use App\Events\Arquivo\SalvarArquivoEvent;
use App\Repositories\Arquivo\ArquivoCompraRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SalvarArquivoListener implements ShouldQueue
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
    public function handle(SalvarArquivoEvent $event): void
    {
        $dataToInsert = $this->retornaDados($event->dadosArquivo);
        (new ArquivoCompraRepository())->insert($dataToInsert);
    }

    private function retornaDados($dadosDocumento)
    {
        return [
            'dat_envio' => now(),
            'cod_compra' => $dadosDocumento->compra->id,
            'cod_edital' => $dadosDocumento->edital->id,
            'cod_pregao' => $dadosDocumento->compra->cod_pregao,
            'caminho' => $dadosDocumento->edital->caminho,
            'location_pncp' => current($dadosDocumento->responsePncp),
            'sequencial_documento' => $this->getSequencialDocumento(current($dadosDocumento->responsePncp)),
            'bol_excluido' => 0
        ];
    }

    private function getSequencialDocumento(string $location): int
    {
        $sequential = explode('/', $location);
        return end($sequential);
    }
}
