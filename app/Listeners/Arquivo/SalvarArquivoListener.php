<?php

namespace App\Listeners\Arquivo;

use App\Events\Arquivo\SalvarArquivoEvent;
use App\Repositories\Arquivo\ArquivoCompraRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SalvarArquivoListener
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
        echo "<pre>"; var_dump($dataToInsert); echo "</pre>"; die;
        (new ArquivoCompraRepository())->insert($dataToInsert);
    }

    private function retornaDados($dadosDocumento)
    {
        return [
            'dat_envio' => now(),
            'cod_compra' => $dadosDocumento->compra['cod_compra'],
            'cod_edital' => $dadosDocumento->edital['id'],
            'cod_pregao' => $dadosDocumento->compra['cod_pregao'],
            'caminho' => $dadosDocumento->edital['caminho'],
            'location_pncp' => $dadosDocumento->responsePncp,
            'sequencial_documento' => 6
        ];
    }
}
