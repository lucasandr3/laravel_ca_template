<?php

namespace App\Listeners\Contrato;

use App\Events\Contrato\ContratoSuccessEvent;
use App\Repositories\Contrato\ContratoRepository;
use Illuminate\Contracts\Queue\ShouldQueue;

class SalvaContrato implements ShouldQueue
{
    private const HOST_CONTRATO_PNCP = 'https://pncp.gov.br/app/contratos/%s/%s/%s';

    /**
     * Create the event listener.
     */
    public function __construct()
    {}

    /**
     * Handle the event.
     */
    public function handle(ContratoSuccessEvent $event): void
    {
        $contrato = $event->contrato;
        $location = $event->location;

        $dataToInsert = $this->retornaDadosContrato($contrato, current($location));
        (new ContratoRepository())->salvaContrato($dataToInsert);
    }

    private function retornaDadosContrato($contrato, $location): array
    {
        $sequencialContrato = $this->getSequencialContrato($location);
        $linkContrato = sprintf(
            self::HOST_CONTRATO_PNCP,
            $contrato['cnpjCompra'],
            $contrato['anoCompra'],
            $sequencialContrato
        );

        return [
            'cod_pregao' => $contrato['codPregao'],
            'cod_fornecedor' => $contrato['codFornecedor'],
            'cnpj_entidade' => $contrato['cnpjCompra'],
            'ano_compra' => $contrato['anoCompra'],
            'sequencial_compra' => $contrato['sequencialCompra'],
            'sequencial_contrato' => $sequencialContrato,
            'tipo_contrato' => $contrato['tipoContratoId'],
            'numero_contrato' => $contrato['numeroContratoEmpenho'],
            'ano_contrato' => $contrato['anoContrato'],
            'numero_processo' => $contrato['processo'],
            'categoria_processo' => $contrato['categoriaProcessoId'],
            'bol_receita' => $contrato['receita'],
            'cod_unidade' => $contrato['codigoUnidade'],
            'doc_fornecedor' => $contrato['niFornecedor'],
            'natureza_fornecedor' => $contrato['tipoPessoaFornecedor'],
            'razao_social_fornecedor' => $contrato['nomeRazaoSocialFornecedor'],
            'objeto_contrato' => $contrato['objetoContrato'],
            'info_complementar' => $contrato['informacaoComplementar'],
            'valor_inicial' => $contrato['valorInicial'],
            'numero_parcelas' => $contrato['numeroParcelas'],
            'valor_parcela' => $contrato['valorParcela'],
            'valor_global' => $contrato['valorGlobal'],
            'valor_acumulado' => $contrato['valorAcumulado'],
            'dat_assinatura' => $contrato['dataAssinatura'],
            'dat_inicio_vigencia' => $contrato['dataVigenciaInicio'],
            'dat_termino_vigencia' => $contrato['dataVigenciaFim'],
            'location' => $linkContrato,
            'location_api_result' => $location,
        ];
    }

    private function getSequencialContrato(string $location): int
    {
        $sequential = explode('/', $location);
        return end($sequential);
    }
}
