<?php

namespace App\Listeners\Processo;

use App\Events\Processo\SalvarProcessoEvent;
use App\Repositories\PregaoEletronico\PregaoEletronicoRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Fluent;

class SalvarProcessoListener implements ShouldQueue
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
    public function handle(SalvarProcessoEvent $event): void
    {
        $dataToInsert = $this->retornaDadosPregao($event->dadosCompra);
        (new PregaoEletronicoRepository())->insert($dataToInsert);
    }

    private function retornaDadosPregao(Fluent $dadosCompra): array
    {
        return [
            'cod_pregao' => $dadosCompra->externalProcess->id,
            'objeto' => $dadosCompra->pregaoEletronico->objetoCompra,
            'processo' => $dadosCompra->externalProcess->processo,
            'numero' => $dadosCompra->pregaoEletronico->numeroCompra,
            'ano' => $dadosCompra->pregaoEletronico->anoCompra,
            'sequencial' => $dadosCompra->pregaoEletronico->sequencialCompra,
            'cnpj_entidade' => $dadosCompra->pregaoEletronico->orgaoEntidade->cnpj,
            'cod_unidade' => $dadosCompra->pregaoEletronico->unidadeOrgao->codigoUnidade,
            'srp' => $dadosCompra->pregaoEletronico->srp,
            'num_controle_pncp' => $dadosCompra->pregaoEletronico->numeroControlePNCP,
            'amparo' => $dadosCompra->pregaoEletronico->amparoLegal->nome,
            'cod_situacao' => $dadosCompra->pregaoEletronico->situacaoCompraId,
            'cod_tipo_instrumento' => $dadosCompra->pregaoEletronico->tipoInstrumentoConvocatorioCodigo,
            'cod_disputa' => $dadosCompra->pregaoEletronico->modoDisputaId,
            'cod_modalidade' => $dadosCompra->pregaoEletronico->modalidadeId,
            'usuario' => $dadosCompra->pregaoEletronico->usuarioNome,
            'total_estimado' => $dadosCompra->pregaoEletronico->valorTotalEstimado,
            'total_homologado' => $dadosCompra->pregaoEletronico->valorTotalHomologado,
            'dat_publicacao_pncp' => $dadosCompra->pregaoEletronico->dataPublicacaoPncp,
            'dat_ini_proposta' => $dadosCompra->pregaoEletronico->dataAberturaProposta,
            'dat_fim_proposta' => $dadosCompra->pregaoEletronico->dataEncerramentoProposta,
            'dat_inclusao' => $dadosCompra->pregaoEletronico->dataInclusao,
            'dat_atualizacao' => $dadosCompra->pregaoEletronico->dataAtualizacao,
            'response_pncp' => json_encode($dadosCompra->pregaoEletronico),
            'compra_uri' => $dadosCompra->responsePncp->compraUri,
            'documento_uri' => $dadosCompra->responsePncp->documentoUri
        ];
    }
}
