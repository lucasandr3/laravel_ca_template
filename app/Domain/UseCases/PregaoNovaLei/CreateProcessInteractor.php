<?php

namespace App\Domain\UseCases\PregaoNovaLei;

use App\Domain\Interfaces\PregaoNovaLei\GetDataItems;
use App\Domain\Interfaces\PregaoNovaLei\GetDataProcess;
use App\Domain\Interfaces\PregaoNovaLei\ProcessFactory;
use App\Domain\Interfaces\PregaoNovaLei\ProcessRepository;
use App\Domain\Interfaces\PregaoNovaLei\ViewModel;
use App\Infra\Services\DocumentUtils;
use App\Infra\Services\HttpService;
use App\Infra\Services\SystemParams;
use Illuminate\Support\Carbon;

class CreateProcessInteractor implements CreateProcessInputPort
{
    public function __construct(
        private readonly CreateProcessOutputPort $output,
        private readonly ProcessRepository       $repository,
        private readonly ProcessFactory          $factory,
        private readonly GetDataProcess          $getDataProcess,
        private readonly GetDataItems            $getDataItems,
        private readonly HttpService             $httpService,
        private readonly DocumentUtils           $documentUtils,
        private readonly SystemParams            $systemParams
    )
    {
    }

    public function createProcess(CreateProcessRequestModel $model): ViewModel
    {
        $parameters = $this->systemParams->sendPurchaseParams();
        $externalProcess = $this->getDataProcess->getProcessById($model->getCodProcess());
        $externalItems = $this->getDataItems->getItemsByProcess($model->getCodProcess());
        $preparedItems = $this->prepareItems($externalItems);

        $instrument = instrument($externalProcess->tipo_processo);

        $linkSistemaOrigem = sprintf(
            $parameters['LINK_SALA_DISPUTA_VISITANTE'],
            base64_encode(encryptParam($model->getCodProcess(), $parameters['KEY_SALA_VISITANTE']))
        );

        $data = $this->factory->make([
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
            'situacaoCompraId' => situationPurchase($externalProcess),
            'informacaoComplementar' => "",
            'amparoLegalId' => supportLegal($externalProcess),
            'linkSistemaOrigem' => $linkSistemaOrigem,
            'itensCompra' => $preparedItems
        ]);

        $firstDocument = $this->documentUtils->preparePurchaseFirstDocumentImp($externalProcess);

        $endpoint = $parameters['HOST_PNCP'] . sprintf(
                $parameters['LINK_POST_COMPRAS'],
                $externalProcess->administration()->cnpj
            );

        try {
            $teste = $this->httpService->postWithDocument($data, $endpoint, $firstDocument);
            $process = $this->repository->create($data);
        } catch (\Exception $e) {
            return $this->output->unableToCreateProcess(new CreateProcessResponseModel($data), $e);
        }

        return $this->output->processCreated(
            new CreateProcessResponseModel($process)
        );
    }

    private function prepareItems($externalItems): array
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
}
