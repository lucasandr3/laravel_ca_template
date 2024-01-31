<?php

namespace App\Domain\UseCases\PregaoEletronico;

use App\Domain\Interfaces\PregaoEletronico\GetDataItems;
use App\Domain\Interfaces\PregaoEletronico\GetDataProcess;
use App\Domain\Interfaces\PregaoEletronico\ProcessFactory;
use App\Domain\Interfaces\PregaoEletronico\ProcessRepository;
use App\Events\Item\ExcluirItemEvent;
use App\Events\Item\SalvarItemEvent;
use App\Events\Processo\AtualizarProcessoEvent;
use App\Events\Processo\ExcluirProcessoEvent;
use App\Events\Processo\SalvarProcessoEvent;
use App\Infra\Services\DocumentUtils;
use App\Infra\Services\HttpService;
use App\Infra\Services\SystemParams;
use Illuminate\Support\Fluent;
use Symfony\Component\HttpFoundation\Response;

class CreateProcessInteractor implements CreateProcessInputPort
{
    public function __construct(
        private readonly PregaoEletronicoOutput  $output,
        private readonly ProcessRepository       $repository,
        private readonly ProcessFactory          $factory,
        private readonly GetDataProcess          $getDataProcess,
        private readonly GetDataItems            $getDataItems,
        private readonly HttpService             $httpService,
        private readonly DocumentUtils           $documentUtils,
        private readonly SystemParams            $systemParams
    ){}

    public function getProcess(InputRequest $input)
    {
        $compraMicroservico = $this->repository->getCompra($input->getCodProcess());

        if ($compraMicroservico === null) {
            return $this->output->notFoundResource();
        }

        $parameters = $this->systemParams->compraParams(dados: new Fluent([
            'cnpj' => $compraMicroservico->cnpj_entidade,
            'ano' => $compraMicroservico->ano,
            'sequencial' => $compraMicroservico->sequencial
        ]));

        $result = $this->httpService->get($parameters);

        return $this->output->process($result?->getBody()->getContents());
    }

    public function createProcess(InputRequest $input)
    {
        $parameters = $this->systemParams->compraParams();
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

        if ($result?->getStatusCode() !== STATUS_CODE_CREATED) {
            return $this->output->unableCreate($result?->getBody()->getContents());
        }

        $responsePncp = json_decode($result->getBody()->getContents());
        $pregaoSalvo = $this->httpService->get($responsePncp->compraUri);

        if ($pregaoSalvo?->getStatusCode() !== STATUS_CODE_OK) {
            return $this->output->notFoundResourceInPncp();
        }

        $dadosCompra = new Fluent([
            'externalProcess' => $externalProcess,
            'processData' => $processData->toArray(),
            'responsePncp' => $responsePncp,
            'pregaoEletronico' => json_decode($pregaoSalvo?->getBody()->getContents())
        ]);

        event(new SalvarProcessoEvent($dadosCompra));
        event(new SalvarItemEvent($dadosCompra));

        return $this->output->created();
    }

    public function updateProcesso(InputRequest $input)
    {
        $compraMicroservico = $this->repository->getCompra($input->getCodProcess());

        if ($compraMicroservico === null) {
            $this->createProcess(new InputRequest([], $input->getCodProcess()));
        }

        $externalProcess = $this->getDataProcess->getProcessById($input->getCodProcess());
        $parameters = $this->systemParams->compraParams(dados: new Fluent([
            'cnpj' => $compraMicroservico->cnpj_entidade,
            'ano' => $compraMicroservico->ano,
            'sequencial' => $compraMicroservico->sequencial
        ]));

        $data = array_merge([
            'process' => $externalProcess,
            'parameters' => $this->systemParams->compraParams()
        ]);

        $processData = $this->factory->make($data);

        $dataToUpdate = array_merge([
            'body' => $processData->getDadosAtualizacao(),
            'endpoint' => $parameters
        ]);

        $result = $this->httpService->put($dataToUpdate);

        if ($result?->getStatusCode() !== Response::HTTP_OK) {
            return $this->output->unableUpdated($result?->getBody()->getContents());
        }

        $dadosCompra = new Fluent([
            'externalProcess' => $externalProcess,
            'processData' => $processData->getDadosAtualizacao(),
        ]);

        event(new AtualizarProcessoEvent($dadosCompra));
        return $this->output->updated();
    }

    public function deleteProcess(InputRequest $input)
    {
        $compraMicroservico = $this->repository->getCompra($input->getCodProcess());

        if ($compraMicroservico === null) {
            return $this->output->notFoundResource();
        }

        $parameters = $this->systemParams->compraParams(dados: new Fluent([
            'cnpj' => $compraMicroservico->cnpj_entidade,
            'ano' => $compraMicroservico->ano,
            'sequencial' => $compraMicroservico->sequencial
        ]));

        $result = $this->httpService->delete($parameters, $input->getReason());

        if ($result?->getStatusCode() !== Response::HTTP_OK) {
            return $this->output->unableDeleted($result?->getBody()->getContents());
        }

        event(new ExcluirItemEvent($compraMicroservico->id));
        event(new ExcluirProcessoEvent($compraMicroservico->cod_pregao));

        return $this->output->deleted();
    }
}
