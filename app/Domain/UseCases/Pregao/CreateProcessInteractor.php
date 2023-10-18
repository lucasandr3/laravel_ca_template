<?php

namespace App\Domain\UseCases\Pregao;

use App\Domain\Interfaces\Pregao\GetDataItems;
use App\Domain\Interfaces\Pregao\GetDataProcess;
use App\Domain\Interfaces\Pregao\ProcessFactory;
use App\Domain\Interfaces\Pregao\ProcessRepository;
use App\Domain\Interfaces\Pregao\ViewModel;
use App\Infra\Services\DocumentUtils;
use App\Infra\Services\HttpService;
use App\Infra\Services\SystemParams;

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
    ){}

    public function createProcess(InputRequest $input): ViewModel
    {
        $parameters = $this->systemParams->sendPurchaseParams();
        $externalProcess = $this->getDataProcess->getProcessById($input->getCodProcess());
        $externalItems = $this->getDataItems->getItemsByProcess($input->getCodProcess());

        $data = array_merge([
            'process' => $externalProcess,
            'items' => $externalItems,
            'parameters' => $parameters
        ]);

        $processData = $this->factory->make($data);
        $firstDocument = $this->documentUtils->preparePurchaseFirstDocumentImp($externalProcess);

        try {
            $this->httpService->postWithDocument($processData, $parameters, $firstDocument);
            $process = $this->repository->create($processData);
        } catch (\Exception $e) {
            return $this->output->unableToCreateProcess(new CreateProcessResponseModel($processData), $e);
        }

        return $this->output->processCreated(
            new CreateProcessResponseModel($process)
        );
    }

    public function deleteProcess(InputRequest $input): ViewModel
    {
        $externalProcess = $this->getDataProcess->getProcessById($input->getCodProcess());
echo "<pre>"; var_dump($externalProcess); echo "</pre>"; die;
        if ($externalProcess) {
            return $this->output->processAlreadyExists(
                new CreateProcessResponseModel($externalProcess)
            );
        }

        try {
            $this->httpService->delete($externalProcess, $input->getReason());
            $process = $this->repository->create($processData);
        } catch (\Exception $e) {
            return $this->output->unableToCreateProcess(new CreateProcessResponseModel($processData), $e);
        }

        return $this->output->processCreated(
            new CreateProcessResponseModel([$process])
        );
    }
}
