<?php

use App\Models\External\Item;
use App\Models\External\Process;
use Illuminate\Support\Carbon;

function prepareDataPregaoNovaLei(Process $externalProcess, $externalItems, array $parameters): array
{
    $instrument = instrument($externalProcess->tipo_processo);

    $linkSistemaOrigem = sprintf(
        $parameters['LINK_SALA_DISPUTA_VISITANTE'],
        base64_encode(encryptParam($externalProcess->id, $parameters['KEY_SALA_VISITANTE']))
    );

    return [
        'cnpj' => $externalProcess->administration()->cnpj,
        'codigoUnidadeCompradora' => $externalProcess->administration()->id,
        'objetoCompra' => PREFIXO_FONTE . $externalProcess->descricao,
        'anoCompra' => $externalProcess->num_ano,
        'srp' => (bool)$externalProcess->registro_preco,
        'numeroCompra' => $externalProcess->numero,
        'numeroProcesso' => $externalProcess->processo,
        'dataAberturaProposta' => $instrument === CONFIG_INSTRUMENTO_ATO ? '' : Carbon::parse($externalProcess->dat_publicacao)->format('Y-m-d\TH:i:s'),
        'dataEncerramentoProposta' => $instrument === CONFIG_INSTRUMENTO_ATO ? '' : Carbon::parse($externalProcess->dat_ini_disputa)->format('Y-m-d\TH:i:s'),
        'tipoInstrumentoConvocatorioId' => $instrument,
        'modalidadeId' => modality($externalProcess->tipo_processo),
        'modoDisputaId' => disputeMode($externalProcess->tipo_modelo, $externalProcess->tipo_processo),
        'situacaoCompraId' => situationPurchase($externalProcess->toArray()),
        'informacaoComplementar' => "",
        'amparoLegalId' => supportLegal($externalProcess->toArray()),
        'linkSistemaOrigem' => $linkSistemaOrigem,
        'itensCompra' => prepareItens($externalItems)
    ];
}

function prepareItens($externalItems)
{
    $arrayItens = [];

    foreach ($externalItems as $item) {
        $quantity = formatValueWithPrecision(CONFIG_MONETARIO_PRECISAO, $item->quantidade, '.', '');
        $budgetedValue = formatValueWithPrecision(CONFIG_MONETARIO_PRECISAO, $item->valor_orcado, '.', '');
        $totalAmountBudgeted = $quantity * $budgetedValue;

        $arrayItens[] = [
            "numeroItem" => $item->id,
            "materialOuServico" => verifyProcessMaterialTypeImp($item),
            "tipoBeneficioId" => returnBeneficioType($item),
            "incentivoProdutivoBasico" => CONFIG_INCENTIVO_FISCAL_NAO,
            "descricao" => truncate($item->descricao, 1500, 0),
            "quantidade" => $quantity,
            "unidadeMedida" => $item->unidade,
            "valorUnitarioEstimado" => $budgetedValue,
            "valorTotal" => $totalAmountBudgeted,
            'itemCategoriaId' => returnItemCategoryId($item->process()),
            "situacaoCompraItemId" => getPurchaseItemSituationImp($item->batch($item->process()->id)->status()->nome),
            "criterioJulgamentoId" => getJudgment($item->process()),
            'orcamentoSigiloso' => !$item->batch($item->process()->id)->bol_mostra_orcado,
            'cod_lote' => $item->cod_lote,
        ];
    }

    return $arrayItens;
}
