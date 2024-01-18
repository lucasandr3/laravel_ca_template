<?php

namespace App\Domain\UseCases\PregaoEletronico;

use App\Domain\Interfaces\PregaoEletronico\GetDataItems;
use App\Domain\Interfaces\PregaoEletronico\GetDataProcess;
use App\Domain\Interfaces\PregaoEletronico\ProcessFactory;
use App\Domain\Interfaces\PregaoEletronico\ProcessRepository;
use App\Domain\Interfaces\PregaoEletronico\ViewModel;
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

        $result = $this->httpService->postWithDocument($processData, $parameters, $firstDocument);
echo "<pre>"; var_dump($result); echo "</pre>"; die;
//        try {
//            $this->httpService->postWithDocument($processData, $parameters, $firstDocument);
//            $process = $this->repository->create($processData);
//        } catch (\Exception $e) {
//            echo "<pre>"; var_dump($e->getMessage()); echo "</pre>"; die;
//            return $this->output->unableToCreateProcess(new CreateProcessResponseModel($processData), $e);
//        }
//
//        return $this->output->processCreated(
//            new CreateProcessResponseModel($process)
//        );
    }

    public function deleteProcess(InputRequest $input): ViewModel
    {
        $externalProcess = $this->getDataProcess->getProcessById($input->getCodProcess());

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
