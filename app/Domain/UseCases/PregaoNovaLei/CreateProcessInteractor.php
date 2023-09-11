<?php

namespace App\Domain\UseCases\PregaoNovaLei;

use App\Domain\Interfaces\PregaoNovaLei\GetDataProcess;
use App\Domain\Interfaces\PregaoNovaLei\ProcessFactory;
use App\Domain\Interfaces\PregaoNovaLei\ProcessRepository;
use App\Domain\Interfaces\PregaoNovaLei\ViewModel;

class CreateProcessInteractor implements CreateProcessInputPort
{
    public function __construct(
        private CreateProcessOutputPort $output,
        private ProcessRepository       $repository,
        private readonly ProcessFactory $factory,
        private readonly GetDataProcess $getDataProcess
    ) {
    }

    public function createProcess(CreateProcessRequestModel $model): ViewModel
    {
        $externalProcess = $this->getDataProcess->getProcessById($model->getCodProcess());

        $process = $this->factory->make([
            'cnpj' => $externalProcess->cnpj,
            'codigoUnidadeCompradora' => $externalProcess->administration()->id,
            'objetoCompra' => PREFIXO_FONTE . $externalProcess->descricao,
            'anoCompra' => $externalProcess->num_ano,
            'srp' => (bool)$externalProcess->registro_preco,
            'numeroCompra' => $externalProcess->numero,
            'numeroProcesso' => $externalProcess->processo,
            'dataAberturaProposta' => $instrument === CONFIG_INSTRUMENTO_ATO ? '' : $externalProcess->dat_publicacao->toDateTimeLocalString(),
            'dataEncerramentoProposta' => $instrument === CONFIG_INSTRUMENTO_ATO ? '' : $externalProcess->dat_ini_disputa->toDateTimeLocalString(),
            'tipoInstrumentoConvocatorioId' => HelpersProcess::getInstrument($externalProcess),
            'modalidadeId' => HelpersProcess::getModality($externalProcess),
            'modoDisputaId' => HelpersProcess::getDisputeMode($externalProcess->tipo_modelo, $externalProcess->tipo_processo),
            'situacaoCompraId' => $this->getSituationPurchase($externalProcess),
            'informacaoComplementar' => "",
            'amparoLegalId' => HelpersProcess::getSupportLegal($externalProcess),
            'linkSistemaOrigem' => ''
        ]);

//        if ($this->repository->exists($process)) {
//            return $this->output->processAlreadyExists(new CreateProcessResponseModel($process));
//        }
//
//        try {
//            //$user = $this->repository->create($user, new PasswordValueObject($request->getPassword()));
//        } catch (\Exception $e) {
//            return $this->output->unableToCreateProcess(new CreateProcessResponseModel($process), $e);
//        }
//
//        return $this->output->processCreated(
//            new CreateProcessResponseModel($process)
//        );
    }
}
