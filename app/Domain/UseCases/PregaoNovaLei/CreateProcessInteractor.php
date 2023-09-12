<?php

namespace App\Domain\UseCases\PregaoNovaLei;

use App\Domain\Interfaces\PregaoNovaLei\GetDataItems;
use App\Domain\Interfaces\PregaoNovaLei\GetDataProcess;
use App\Domain\Interfaces\PregaoNovaLei\ProcessFactory;
use App\Domain\Interfaces\PregaoNovaLei\ProcessRepository;
use App\Domain\Interfaces\PregaoNovaLei\ViewModel;

class CreateProcessInteractor implements CreateProcessInputPort
{
    public function __construct(
        private readonly CreateProcessOutputPort $output,
        private readonly ProcessRepository       $repository,
        private readonly ProcessFactory          $factory,
        private readonly GetDataProcess          $getDataProcess,
        private readonly GetDataItems            $getDataItems
    ) {}

    public function createProcess(CreateProcessRequestModel $model): ViewModel
    {
        $externalProcess = $this->getDataProcess->getProcessById($model->getCodProcess());
        $externalItems = $this->getDataItems->getItemsByProcess($model->getCodProcess());
        $preparedItems = $this->prepareItems($externalItems);

        $instrument = instrument($externalProcess->tipo_processo);

        $data = $this->factory->make([
            'cnpj' => $externalProcess->administration()->cnpj,
            'codigoUnidadeCompradora' => $externalProcess->administration()->id,
            'objetoCompra' => PREFIXO_FONTE . $externalProcess->descricao,
            'anoCompra' => $externalProcess->num_ano,
            'srp' => (bool)$externalProcess->registro_preco,
            'numeroCompra' => $externalProcess->numero,
            'numeroProcesso' => $externalProcess->processo,
            'dataAberturaProposta' => $instrument === CONFIG_INSTRUMENTO_ATO ? '' : $externalProcess->dat_publicacao->toDateTimeLocalString(),
            'dataEncerramentoProposta' => $instrument === CONFIG_INSTRUMENTO_ATO ? '' : $externalProcess->dat_ini_disputa->toDateTimeLocalString(),
            'tipoInstrumentoConvocatorioId' => $instrument,
            'modalidadeId' => modality($externalProcess->tipo_processo),
            'modoDisputaId' => disputeMode($externalProcess->tipo_modelo, $externalProcess->tipo_processo),
            'situacaoCompraId' => situationPurchase($externalProcess),
            'informacaoComplementar' => "",
            'amparoLegalId' => supportLegal($externalProcess),
            'linkSistemaOrigem' => 'http://portal.licitanet.com',
            'itemsCompra' => $preparedItems
        ]);

        if ($this->repository->exists($data)) {
            return $this->output->processAlreadyExists(new CreateProcessResponseModel($data));
        }

        try {
            $process = $this->repository->create($data);
        } catch (\Exception $e) {
            return $this->output->unableToCreateProcess(new CreateProcessResponseModel($process), $e);
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
                'itemCategoriaId' =>  returnItemCategoryId($item->process()),
                "situacaoCompraItemId" => getPurchaseItemSituationImp($item->batch($item->process()->id)->status()->nome),
                "criterioJulgamentoId" => getJudgment($item->process()),
                'orcamentoSigiloso'=> !$item->batch($item->process()->id)->bol_mostra_orcado,
                'cod_lote'=> $item->cod_lote,
            ];
        }

        return $arrayItens;
    }
}
