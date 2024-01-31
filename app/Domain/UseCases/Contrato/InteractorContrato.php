<?php

namespace App\Domain\UseCases\Contrato;

use App\Domain\Interfaces\Contrato\ContratoRepositoryInterface;
use App\Domain\Interfaces\Unidade\UnidadeRepositoryInterface;
use App\Events\Contrato\ContratoErrorEvent;
use App\Events\Contrato\ContratoSuccessEvent;
use App\Events\Contrato\DeleteContratoEvent;
use App\Infra\Services\HttpService;
use App\Infra\Services\SystemParams;
use JsonException;
use function Symfony\Component\String\b;
use function Symfony\Component\String\u;
use function Symfony\Component\Translation\t;

class InteractorContrato
{
    public function __construct
    (
        private readonly ContratoRepositoryInterface $repository,
        private readonly SystemParams $systemParams,
        private readonly HttpService $httpService,
        private readonly ContratoOutput $output
    )
    {}

    /**
     * @throws JsonException
     */
    public function saveContract(InputRequestContrato $input)
    {
        $parameters = $this->systemParams->contratoParams(cnpjOrgao: $input->getCnpjCompra());

        $data = array_merge([
            'body' => $input->getContrato(),
            'endpoint' => $parameters
        ]);

        $result = $this->httpService->post($data, true);

        if ($result?->getStatusCode() !== STATUS_CODE_CREATED) {
            return $this->output->unableCreate($result?->getBody()->getContents());
        }

        event(new ContratoSuccessEvent($input->getContrato(), $result?->getHeader('location')));
        return $this->output->contrato(json_encode(['message' => 'contrato cadastrado com sucesso.'], JSON_THROW_ON_ERROR));
    }

    public function delContract(InputRequestContrato $input)
    {
        $contrato = $this->repository->getContrato($input->getSequencialContrato(), $input->getCodProcesso());

        if (!$contrato) {
            return $this->output->notFoundResource();
        }

        $parameters = $this->systemParams->contratoParams(dados: [
            'cnpj' => $contrato->cnpj_entidade,
            'anoCompra' => $contrato->ano_compra,
            'sequencialContrato' => $contrato->sequencial_contrato
        ]);

        $result = $this->httpService->delete($parameters, $input->getJustificativa());

        if ($result?->getStatusCode() !== STATUS_CODE_OK) {
            return $this->output->unableDeleted($result?->getBody()->getContents());
        }

        event(new DeleteContratoEvent($contrato->id));
        return $this->output->deleted();
    }

    public function sendDocumentContrato(InputRequestContratoArquivo $input)
    {
        $contrato = $this->repository->getContrato($input->getSequencialContrato(), $input->getCodProcesso());

        if (!$contrato) {
            return $this->output->notFoundResource();
        }

        $parameters = $this->systemParams->contratoParams(arquivo: [
            'cnpj' => $contrato->cnpj_entidade,
            'anoCompra' => $contrato->ano_compra,
            'sequencialContrato' => $contrato->sequencial_contrato
        ]);

//        $result = $this->httpService->postWithDocument([], $parameters, );
//        return $this->output->todasUnidades($result);
    }

    /**
     * @throws JsonException
     */
    public function getUnidadePorCodigo(InputRequestUnidade $input)
    {
        $unidadeExterna = $this->unidadeRepositoryExternal->getUnidade($input->getCodigoUnidade());

        if ($unidadeExterna) {

            $parameters = $this->systemParams->unidadeParams(
                $unidadeExterna->cnpj,
                $input->getCodigoUnidade()
            );

            $result = $this->httpService->get($parameters);

            if ($result?->getStatusCode() === STATUS_CODE_NOT_FOUND) {
                return $this->output->notFoundResource($result?->getBody()->getContents());
            }

            return $this->output->unidade($result?->getBody()->getContents());
        }

        return $this->output->notFoundResource(json_encode(['message' => 'Unidade não encontrada'], JSON_THROW_ON_ERROR));
    }

    /**
     * @throws JsonException
     */
    public function updateUnidade(InputRequestUnidade $input)
    {
        $unidadeExterna = $this->unidadeRepositoryExternal->getUnidade($input->getCodigoUnidade());

        if ($unidadeExterna) {
            $parameters = $this->systemParams->unidadeParams($unidadeExterna->cnpj);

            $data = array_merge([
                'body' => $input->getDadosUnidade(),
                'endpoint' => $parameters
            ]);

            $result = $this->httpService->put($data);

            if ($result?->getStatusCode() !== STATUS_CODE_OK) {
                return $this->output->unableUpdated($result?->getBody()->getContents());
            }

            return $this->output->unidade(json_encode(['message' => 'Unidade atualizada com sucesso.'], JSON_THROW_ON_ERROR));
        }

        return $this->output->notFoundResource(json_encode(['message' => 'Unidade não encontrada'], JSON_THROW_ON_ERROR));
    }

    private function unidadeCadastrada(string $documento, int $codigoUnidade): bool|string
    {
        $parameters = $this->systemParams->unidadeParams(
            cnpjOrgao: $documento,
            codigoOuDocumento: $codigoUnidade
        );

        $result = $this->httpService->get($parameters);

        if ($result?->getStatusCode() !== STATUS_CODE_OK) {
            return false;
        }

        return $result?->getBody()->getContents();
    }
}
