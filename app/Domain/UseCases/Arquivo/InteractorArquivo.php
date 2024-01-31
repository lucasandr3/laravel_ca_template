<?php

namespace App\Domain\UseCases\Arquivo;

use App\Domain\Interfaces\PregaoEletronico\GetDataProcess;
use App\Domain\Interfaces\PregaoEletronico\ProcessRepository;
use App\Events\Arquivo\ExcluirArquivoEvent;
use App\Events\Arquivo\SalvarArquivoEvent;
use App\Infra\Services\DocumentUtils;
use App\Infra\Services\HttpService;
use App\Infra\Services\SystemParams;
use App\Shared\Interfaces\GetExternalDocument;
use Illuminate\Support\Fluent;
use Symfony\Component\HttpFoundation\Response;

class InteractorArquivo
{
    public function __construct
    (
        private readonly ProcessRepository $repository,
        private readonly GetDataProcess $getDataProcess,
        private readonly GetExternalDocument $externalDocument,
        private readonly SystemParams $systemParams,
        private readonly DocumentUtils $documentUtils,
        private readonly HttpService $httpService,
        private readonly ArquivoOutput $output
    )
    {}

    public function sendDocument(InputArquivoRequest $input)
    {
        $externalProcess = $this->getDataProcess->getProcessById($input->getCodProcess());
        $compraMicroservico = $this->repository->getCompra($input->getCodProcess());
        $externalDocument = $this->externalDocument->getEditalDocument($input->getcodDocumento());

        $parameters = $this->systemParams->arquivoParams(dados: new Fluent([
            'cnpj' => $compraMicroservico->cnpj_entidade,
            'ano' => $compraMicroservico->ano,
            'sequencial' => $compraMicroservico->sequencial
        ]));

        $document = $this->documentUtils->prepareDocumentImp($externalDocument, $externalProcess);

        $result = $this->httpService->postDocument($document, $parameters);

        if ($result?->getStatusCode() !== Response::HTTP_CREATED) {
            return $this->output->unableUploaded($result?->getBody()->getContents());
        }

        $dadosArquivo = new Fluent([
            'compra' => $compraMicroservico,
            'edital' => $externalProcess,
            'responsePncp' => $result?->getHeader('location')
        ]);

        event(new SalvarArquivoEvent($dadosArquivo));
        return $this->output->success();
    }

    public function deleteDocument(InputArquivoRequest $input)
    {
        $compraMicroservico = $this->repository->getCompra($input->getCodProcess());

        $parameters = $this->systemParams->arquivoParams(dados: new Fluent([
            'cnpj' => $compraMicroservico->cnpj_entidade,
            'ano' => $compraMicroservico->ano,
            'sequencial' => $compraMicroservico->sequencial,
            'sequencialDocumento' => $input->getSequencialDocumento(),
        ]), delFile: true);

        $result = $this->httpService->delete($parameters, $input->getReason());

        if ($result?->getStatusCode() !== Response::HTTP_OK) {
            return $this->output->unableDeleted($result?->getBody()->getContents());
        }

        event(new ExcluirArquivoEvent());
        return $this->output->deleted();
    }

//    public function getOrgaos(array $filtro)
//    {
//        $parameters = $this->systemParams->orgaoParams(filtro: $filtro);
//        $result = $this->httpService->get($parameters)?->getBody()->getContents();
//        return $this->output->allOrgans($result);
//    }
//
//    public function getOrgaoPorDocumento(InputRequestOrgao $input)
//    {
//        $parameters = $this->systemParams->orgaoParams($input->getDocumento());
//        $result = $this->httpService->get($parameters);
//
//        if ($result?->getStatusCode() === STATUS_CODE_NOT_FOUND) {
//            return $this->output->notFoundResource($result?->getBody()->getContents());
//        }
//
//        return $this->output->organ($result?->getBody()->getContents());
//    }
//
//    public function getOrgaoPorCodigo(InputRequestOrgao $input)
//    {
//        $parameters = $this->systemParams->orgaoParams($input->getCodigoOrgao());
//        $result = $this->httpService->get($parameters);
//
//        if ($result?->getStatusCode() === STATUS_CODE_NOT_FOUND) {
//            return $this->output->notFoundResource($result?->getBody()->getContents());
//        }
//
//        return $this->output->organ($result?->getBody()->getContents());
//    }
//
//    public function updateOrgao(InputRequestOrgao $input)
//    {
//        $parameters = $this->systemParams->orgaoParams();
//
//        $data = array_merge([
//            'body' => ['cnpj' => $input->getDocumento()],
//            'endpoint' => $parameters
//        ]);
//
//        $result = $this->httpService->put($data);
//
//        if ($result?->getStatusCode() === STATUS_CODE_NOT_FOUND) {
//            return $this->output->unableUpdated($result?->getBody()->getContents());
//        }
//
//        return $this->output->organ($result?->getBody()->getContents());
//    }
//
//    private function orgaoCadastrado(string $documento): bool|string
//    {
//        $parameters = $this->systemParams->orgaoParams($documento);
//        $result = $this->httpService->get($parameters);
//
//        if ($result?->getStatusCode() === STATUS_CODE_NOT_FOUND) {
//            return false;
//        }
//
//        return $result?->getBody()->getContents();
//    }
}
