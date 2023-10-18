<?php

namespace App\Domain\UseCases\Dispensa;

use App\Domain\Interfaces\Dispensa\DispensaFactoryInterface;
use App\Domain\Interfaces\Dispensa\DispensaRepositoryInterface;
use App\Domain\Interfaces\Dispensa\GetDataDispensa;
use App\Infra\Services\DocumentUtils;
use App\Infra\Services\HttpService;
use App\Infra\Services\SystemParams;
use App\Shared\Interfaces\GetDataProcess;
use App\Shared\Interfaces\GetItemsProcess;

class DispensaInteractor implements CreateDispensa
{
    public function __construct(
        private readonly OutputPort                  $output,
        private readonly DispensaRepositoryInterface $repository,
        private readonly DispensaFactoryInterface    $factory,
        private readonly GetDataProcess              $getDataProcess,
        private readonly GetItemsProcess             $getItemsProcess,
        private readonly HttpService                 $httpService,
        private readonly DocumentUtils               $documentUtils,
        private readonly SystemParams                $systemParams
    )
    {
    }

    public function createProcess(InputDispensa $input)
    {
        $parameters = $this->systemParams->sendPurchaseParams();
        $externalProcess = $this->getDataProcess->getProcessById($input->getCodProcess());
        $externalItems = $this->getItemsProcess->getItemsByProcess($input->getCodProcess());

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
            return $this->output->unableToCreateProcess(new DispensaResponseModel($processData), $e);
        }

        return $this->output->processCreated(
            new DispensaResponseModel($process)
        );
    }

    public function deleteProcess(InputDispensa $input)
    {
        $parameters = $this->systemParams->sendPurchaseParams();

        try {
            $this->httpService->delete($input->getCodProcess(), $parameters, $input->getReason());
        } catch (\Exception $e) {
            echo "<pre>"; var_dump($e->getMessage()); echo "</pre>"; die;
        }

        echo "<pre>"; var_dump($parameters); echo "</pre>"; die;
    }
}
