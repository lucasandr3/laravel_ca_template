<?php

namespace App\Listeners\Item;

use App\Events\Item\AtualizaItemEvent;
use App\Models\PregaoEletronico\Compra;
use App\Repositories\Item\ItemRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Fluent;

class AtualizaItemListener
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
    public function handle(AtualizaItemEvent $event): void
    {
        $codProcesso = $event->dadosItem->externalProcess->id;
        $codItem = $event->dadosItem->item['numeroItem'];

        $dataToUpdate = $this->retornaDados($event->dadosItem, $codProcesso);
        (new ItemRepository())->updateOneItem($dataToUpdate, $codProcesso, $codItem);
    }

    private function retornaDados(Fluent $dadosItem, $codProcesso): array
    {
        return [
            "cod_compra" => $dadosItem->compra->id,
            "cod_pregao" => $codProcesso,
            "numero_item" => $dadosItem->item['numeroItem'],
            "material_servico" => $dadosItem->item['materialOuServico'],
            "tipo_beneficio" => $dadosItem->item['tipoBeneficioId'],
            "incentivo_produtivo_basico" => $dadosItem->item['incentivoProdutivoBasico'],
            "descricao" => $dadosItem->item['descricao'],
            "quantidade" => $dadosItem->item['quantidade'],
            "unidade_medida" => $dadosItem->item['unidadeMedida'],
            "valor_unitario_estimado" => $dadosItem->item['valorUnitarioEstimado'],
            "valor_total" => $dadosItem->item['valorTotal'],
            "situacao_compra_item" => $dadosItem->item['situacaoCompraItemId'],
            "criterio_julgamento" => $dadosItem->item['criterioJulgamentoId'],
            "cod_situacao_item" => $dadosItem->item['situacaoCompraItemId'],
            "valor_unitario_homologado" => $dadosItem->item['valorUnitarioHomologado'] ?? null,
            "valor_total_homologado" => $dadosItem->item['valorTotalHomologado'] ?? null,
            "percentual_desconto" => $dadosItem->item['percentualDesconto'] ?? null,
            "data_resultado" => $dadosItem->data['homologationDate'] ?? null,
            "sequencial_resultado" => $dadosItem->data['sequencialResultado'] ?? null,
            'cod_lote' => $dadosItem->item['codLote']
        ];
    }
}
