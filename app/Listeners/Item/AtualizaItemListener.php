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

    private function retornaDados(Fluent $dadosCompra, $codProcesso): array
    {
        return [
            "dat_envio" => now(),
            "cod_compra" => $dadosCompra->compra->id,
            "cod_pregao" => $codProcesso,
            "numero_item" => $dadosCompra->item['numeroItem'],
            "material_servico" => $dadosCompra->item['materialOuServico'],
            "tipo_beneficio" => $dadosCompra->item['tipoBeneficioId'],
            "incentivo_produtivo_basico" => $dadosCompra->item['incentivoProdutivoBasico'],
            "descricao" => $dadosCompra->item['descricao'],
            "quantidade" => $dadosCompra->item['quantidade'],
            "unidade_medida" => $dadosCompra->item['unidadeMedida'],
            "valor_unitario_estimado" => $dadosCompra->item['valorUnitarioEstimado'],
            "valor_total" => $dadosCompra->item['valorTotal'],
            "situacao_compra_item" => $dadosCompra->item['situacaoCompraItemId'],
            "criterio_julgamento" => $dadosCompra->item['criterioJulgamentoId'],
            "cod_situacao_item" => $dadosCompra->item['situacaoCompraItemId'],
            "valor_unitario_homologado" => null,
            "valor_total_homologado" => null,
            "percentual_desconto" => null,
            "data_resultado" => null,
            "sequencial_resultado" => null,
            'cod_lote' => $dadosCompra->item['codLote']
        ];
    }
}
