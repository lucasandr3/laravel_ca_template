<?php

use App\Models\External\Item;
use App\Models\External\Process;
use Illuminate\Database\Eloquent\Collection;

function instrument(int $typeProcess): int
{
    $instrument = new Collection([
        CONFIG_TIPO_PROCESSO_PREGAO => CONFIG_INSTRUMENTO_EDITAL,
        CONFIG_TIPO_PROCESSO_CONCORRENCIA => CONFIG_INSTRUMENTO_EDITAL,
        CONFIG_TIPO_PROCESSO_DISPENSA => CONFIG_INSTRUMENTO_AVISO,
        CONFIG_TIPO_INEXIGIBILIDADE => CONFIG_INSTRUMENTO_ATO,
        CONFIG_TIPO_COMPRA_DIRETA => CONFIG_INSTRUMENTO_ATO,
        CONFIG_TIPO_LEILAO_ELETRONICO => CONFIG_INSTRUMENTO_EDITAL,
        CONFIG_TIPO_PREGAO_PRESENCIAL => CONFIG_INSTRUMENTO_EDITAL
    ]);

    return $instrument->get($typeProcess);
}

function modality(int $typeProcess): int
{
    $modalities = new Collection([
        CONFIG_TIPO_PROCESSO_PREGAO => CONFIG_MODALIDADE_PREGAOELETRONICO,
        CONFIG_TIPO_PROCESSO_CONCORRENCIA => CONFIG_MODALIDADE_CONCORRENCIAELETRONICA,
        CONFIG_TIPO_PROCESSO_DISPENSA => CONFIG_MODALIDADE_DISPENSA,
        CONFIG_TIPO_INEXIGIBILIDADE => CONFIG_MODALIDADE_INEXIGIBILIDADE,
        CONFIG_TIPO_COMPRA_DIRETA => CONFIG_MODALIDADE_DISPENSA,
        CONFIG_TIPO_LEILAO_ELETRONICO => CONFIG_MODALIDADE_LEILAOELETRONICO,
        CONFIG_TIPO_PREGAO_PRESENCIAL => CONFIG_MODALIDADE_PREGAOPRESENCIAL
    ]);

    return $modalities->get($typeProcess);
}

function disputeMode(int $model, int $typeProcess): int
{
    $modos = new Collection([
        MODO_ABERTO => CONFIG_PNCP_MODO_ABERTO,
        MODO_ABERTOFECHADO => CONFIG_PNCP_MODO_ABERTOFECHADO,
        MODO_FECHADOABERTO => CONFIG_PNCP_FECHADOABERTO
    ]);

    if ($typeProcess === CONFIG_TIPO_PROCESSO_DISPENSA) {
        $mode = CONFIG_PCNP_MODO_DISPENSA;
    } elseif (in_array($typeProcess, [CONFIG_TIPO_INEXIGIBILIDADE, CONFIG_TIPO_COMPRA_DIRETA], true)) {
        $mode = CONFIG_PNCP_NAOSEAPLICA;
    } else {
        $mode = $modos->get($model);
    }

    return $mode;
}

function situationPurchase(Process $process)
{
    if ($process->bol_cancelado) {
        return CONFIG_SITUACAO_ANULADA;
    } elseif ($process->bol_suspender) {
        return CONFIG_SITUACAO_SUSPENSA;
    } elseif ($process->bol_revogado) {
        return CONFIG_SITUACAO_REVOGADA;
    } else {
        return CONFIG_SITUACAO_DIVULGADA;
    }
}

function supportLegal(Process $process): int
{
    if ($process->tipo_processo == CONFIG_TIPO_PROCESSO_CONCORRENCIA) {
        $support = CONFIG_LEI_141332021_ART_28II;
    } elseif ($process->tipo_processo == CONFIG_TIPO_PROCESSO_PREGAO) {
        $support = CONFIG_LEI_141332021_ART_28I;
    } elseif ($process->tipo_processo == CONFIG_TIPO_PREGAO_PRESENCIAL) {
        $support = CONFIG_LEI_141332021_ART_28I;
    } elseif ($process->tipo_processo == CONFIG_TIPO_LEILAO_ELETRONICO){
        $support = CONFIG_LEI_141332021_ART_28IV;
    } else {
        #compra direta, inexigibilidade, dispensa, leilao
        $processSupportLegal = $process->processSupportLegal()->getResults()->first();
        $support = $processSupportLegal->supportLegal()->cod_pncp;
    }

    return $support;
}

function getJudgment(Process $process): int
{
    if (in_array($process->tipo_processo, [CONFIG_TIPO_COMPRA_DIRETA, CONFIG_TIPO_INEXIGIBILIDADE])) {
        return CONFIG_CRITERIO_NAOSEAPLICA;
    }

    switch ($process->cod_tipo_pregao) {
        case CONFIG_JULGAMENTO_MENOR_I:
        case CONFIG_JULGAMENTO_MENOR_L:
        case CONFIG_JULGAMENTO_MENOR_D:
            return CONFIG_CRITERIO_MENORPRECO;
        case CONFIG_JULGAMENTO_MAIOR_D:
        case CONFIG_JULGAMENTO_MAIOR_DL:
            return CONFIG_CRITERIO_MAIORDESCONTO;
        case CONFIG_JULGAMENTO_MAIOR_P:
            return CONFIG_CRITERIO_MAIORLANCE;
        default:
            return CONFIG_CRITERIO_NAOSEAPLICA;
    }
}

function verifyProcessMaterialTypeImp(Item $item)
{
    if($item->process()->tipo_processo != CONFIG_TIPO_LEILAO_ELETRONICO){
        return (isMaterialTypeImp($item->process()->cod_suprimento) ? CONFIG_SUPRIMENTO_MATERIAL : CONFIG_SUPRIMENTO_SERVICO);
    }
    return CONFIG_SUPRIMENTO_MATERIAL;
}

function returnBeneficioType(Item $item)
{
    if($item->process()->tipo_processo != CONFIG_TIPO_LEILAO_ELETRONICO){
        return (isExclusiveMeImp($item->meepp) ? CONFIG_BENEFICIO_COTAEXCLUSIVAMEEP : CONFIG_BENEFICIO_SEMBENEFICIO);
    }
    return CONFIG_PNCP_NAOSEAPLICA;
}

function returnItemCategoryId(Process $process)
{
    if($process->tipo_processo != CONFIG_TIPO_LEILAO_ELETRONICO){
        return CONFIG_TIPO_CATEGORIA_SUPRIMENTO_DEFAULT;
    }

    $supriments = new Collection([
        CONFIG_TIPO_SUPRIMENTO_BENS_MOVEIS => CONFIG_TIPO_CATEGORIA_SUPRIMENTO_BENS_MOVEIS,
        CONFIG_TIPO_SUPRIMENTO_BENS_IMOVEIS => CONFIG_TIPO_CATEGORIA_SUPRIMENTO_BENS_IMOVEIS,
    ]);

    return $supriments->get($process->cod_suprimento);
}

function getPurchaseItemSituationImp(string $batchStatus): int
{
    switch (strtolower($batchStatus)) {
        case 'deserto':
            return CONFIG_SITUACAO_ITEM_DESERTO;
        case 'cancelado':
            return CONFIG_SITUACAO_ITEM_CANCELADO;
        case 'fracassado':
            return CONFIG_SITUACAO_ITEM_FRACASSADO;
        case 'homologado':
            return CONFIG_SITUACAO_ITEM_HOMOLOGADO;
        default:
            return CONFIG_SITUACAO_ITEM_PENDENTE;
    }
}

function isMaterialTypeImp(int $supplyType): bool
{
    return $supplyType == CONFIG_TIPO_SUPRIMENTO_MATERIAL;
}

function isExclusiveMeImp(int $benefitType): bool
{
    return $benefitType == CONFIG_BENEFICIO_COTAEXCLUSIVAMEEP;
}

function formatValueWithPrecision(int $precisao, $data, string $decimalSeparator = ",", string $thousandsSeparator = "."): float
{
    if (isset($data)) {
        $value = explode('.', $data);
        $finalValue = $value[0] . "." . substr($value[1] ?? "", 0, $precisao);
        return number_format($finalValue, $precisao, $decimalSeparator, $thousandsSeparator);
    } else {
        return number_format(0, $precisao, $decimalSeparator, $thousandsSeparator);
    }
}

function truncate(string $string, int $width, int $start = 0, string $trim_marker = '...'): string
{
    return mb_strimwidth($string, $start, $width, $trim_marker);
}
