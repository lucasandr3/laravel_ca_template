<?php

namespace App\Listeners\Processo;

use App\Events\Processo\AtualizarProcessoEvent;
use App\Repositories\PregaoEletronico\PregaoEletronicoRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Fluent;

class AtualizarProcessoListener implements ShouldQueue
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
    public function handle(AtualizarProcessoEvent $event): void
    {
        $dataToUpdate = $this->retornaDadosPregao($event->dadosCompra);
        (new PregaoEletronicoRepository())->atualizaCompra($event->dadosCompra->externalProcess->id, $dataToUpdate);
    }

    private function retornaDadosPregao(Fluent $dadosCompra): array
    {
        return [
            'cod_tipo_instrumento' => $dadosCompra->processData['tipoInstrumentoConvocatorioId'],
            'cod_modalidade' => $dadosCompra->processData['modalidadeId'],
            'cod_disputa' => $dadosCompra->processData['modoDisputaId'],
            'numero' => $dadosCompra->processData['numeroCompra'],
            'processo' => $dadosCompra->processData['numeroProcesso'],
            'cod_situacao' => $dadosCompra->processData['situacaoCompraId'],
            'objeto' => $dadosCompra->processData['objetoCompra'],
            'srp' => $dadosCompra->processData['srp'],
            'dat_ini_proposta' => $dadosCompra->processData['dataAberturaProposta'],
            'dat_fim_proposta' => $dadosCompra->processData['dataEncerramentoProposta']
        ];
    }
}
