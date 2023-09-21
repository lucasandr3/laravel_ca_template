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
    ) {}

    public function createProcess(CreateProcessRequestModel $input): ViewModel
    {
        $parameters = $this->systemParams->sendPurchaseParams();
        $externalProcess = $this->getDataProcess->getProcessById($input->getCodProcess());
        $externalItems = $this->getDataItems->getItemsByProcess($input->getCodProcess());

        $data = $this->factory->make(prepareDataPregaoNovaLei(
            $externalProcess, $externalItems, $parameters
        ));

        $firstDocument = $this->documentUtils->preparePurchaseFirstDocumentImp($externalProcess);

        try {
            $this->httpService->postWithDocument($data, $parameters, $firstDocument);
            $process = $this->repository->create($data);
        } catch (\Exception $e) {
            return $this->output->unableToCreateProcess(new CreateProcessResponseModel($data), $e);
        }

        return $this->output->processCreated(
            new CreateProcessResponseModel($process)
        );
    }
}
