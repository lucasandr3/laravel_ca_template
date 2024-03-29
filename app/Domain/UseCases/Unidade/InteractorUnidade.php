<?php

namespace App\Domain\UseCases\Unidade;

use App\Domain\Interfaces\Unidade\UnidadeRepositoryInterface;
use App\Infra\Services\HttpService;
use App\Infra\Services\SystemParams;
use JsonException;

class InteractorUnidade
{
    public function __construct
    (
        private readonly UnidadeRepositoryInterface $unidadeRepositoryExternal,
        private readonly SystemParams $systemParams,
        private readonly HttpService $httpService,
        private readonly UnidadeOutput $output,
    )
    {}

    /**
     * @throws JsonException
     */
    public function createUnidade(InputRequestUnidade $input)
    {
        $unidadeExterna = $this->unidadeRepositoryExternal->getUnidade($input->getCodigoUnidade());
        $unidadeCadastrada = $this->unidadeCadastrada($unidadeExterna->cnpj, $input->getCodigoUnidade());

        if ($unidadeCadastrada) {
            return $this->output->unidade($unidadeCadastrada);
        }

        $parameters = $this->systemParams->unidadeParams(cnpjOrgao: $unidadeExterna->cnpj);

        $data = array_merge([
            'body' => $input->getDadosUnidade(),
            'endpoint' => $parameters
        ]);

        $result = $this->httpService->post($data, true);

        if ($result?->getStatusCode() !== STATUS_CODE_CREATED) {
            return $this->output->unableCreate($result?->getBody()->getContents());
        }

        return $this->output->unidade(json_encode(['message' => 'Unidade cadastrada com sucesso.'], JSON_THROW_ON_ERROR));
    }

    public function getUnidades(InputRequestUnidade $input)
    {
        $parameters = $this->systemParams->unidadeParams(cnpjOrgao: $input->getDocumento());
        $result = $this->httpService->get($parameters)?->getBody()->getContents();
        return $this->output->todasUnidades($result);
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
