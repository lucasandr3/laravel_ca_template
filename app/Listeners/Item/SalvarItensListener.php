<?php

namespace App\Listeners\Item;

use App\Events\Item\SalvarItemEvent;
use App\Models\PregaoEletronico\Compra;
use App\Repositories\Item\ItemRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Fluent;

class SalvarItensListener implements ShouldQueue
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
    public function handle(SalvarItemEvent $event): void
    {
        $dataToInsert = $this->retornaDadosItens($event->dadosCompra);
        (new ItemRepository())->salvaItens($dataToInsert->toArray());
    }

    private function retornaDadosItens(Fluent $dadosCompra)
    {
        $compra = Compra::query()->where('cod_pregao', '=', $dadosCompra->externalProcess->id)->first();
        return collect($dadosCompra->processData['itensCompra'])->map(function ($item) use ($compra, $dadosCompra) {
            return [
                "dat_envio" => now(),
                "cod_compra" => $compra->id,
                "cod_pregao" => $dadosCompra->externalProcess->id,
                "numero_item" => $item['numeroItem'],
                "material_servico" => $item['materialOuServico'],
                "tipo_beneficio" => $item['tipoBeneficioId'],
                "incentivo_produtivo_basico" => $item['incentivoProdutivoBasico'],
                "descricao" => $item['descricao'],
                "quantidade" => $item['quantidade'],
                "unidade_medida" => $item['unidadeMedida'],
                "valor_unitario_estimado" => $item['valorUnitarioEstimado'],
                "valor_total" => $item['valorTotal'],
                "situacao_compra_item" => $item['situacaoCompraItemId'],
                "criterio_julgamento" => $item['criterioJulgamentoId'],
                "cod_situacao_item" => $item['situacaoCompraItemId'],
                "valor_unitario_homologado" => null,
                "valor_total_homologado" => null,
                "percentual_desconto" => null,
                "data_resultado" => null,
                "sequencial_resultado" => null,
                'cod_lote' => $item['codLote']
            ];
        });
    }
}
