<?php

namespace App\Domain\UseCases\Orgao;

use App\Infra\Services\HttpService;
use App\Infra\Services\SystemParams;

class InteractorOrgao
{
    public function __construct
    (
        private readonly SystemParams $systemParams,
        private readonly HttpService $httpService,
        private readonly OrgaoOutput $output
    )
    {}

    public function createOrgao(InputRequestOrgao $input)
    {
        $orgaoCadastrado = $this->orgaoCadastrado($input->getDocumento());

        if ($orgaoCadastrado) {
            return $this->output->organ($orgaoCadastrado);
        }

        $parameters = $this->systemParams->orgaoParams();

        $data = array_merge([
            'body' => $input->getDadosOrgao(),
            'endpoint' => $parameters
        ]);

        $result = $this->httpService->post($data, true);

        if ($result->getStatusCode() !== STATUS_CODE_CREATED) {
            return $this->output->unableCreate($result->getBody()->getContents());
        }

        return $this->output->organ($result->getBody()->getContents());
    }

    public function getOrgaos(array $filtro)
    {
        $parameters = $this->systemParams->orgaoParams(filtro: $filtro);
        $result = $this->httpService->get($parameters)->getBody()->getContents();
        return $this->output->allOrgans($result);
    }

    public function getOrgaoPorDocumento(InputRequestOrgao $input)
    {
        $parameters = $this->systemParams->orgaoParams($input->getDocumento());
        $result = $this->httpService->get($parameters);

        if ($result->getStatusCode() === STATUS_CODE_NOT_FOUND) {
            return $this->output->notFoundResource($result->getBody()->getContents());
        }

        return $this->output->organ($result->getBody()->getContents());
    }

    public function getOrgaoPorCodigo(InputRequestOrgao $input)
    {
        $parameters = $this->systemParams->orgaoParams($input->getCodigoOrgao());
        $result = $this->httpService->get($parameters);

        if ($result->getStatusCode() === STATUS_CODE_NOT_FOUND) {
            return $this->output->notFoundResource($result->getBody()->getContents());
        }

        return $this->output->organ($result->getBody()->getContents());
    }

    public function updateOrgao(InputRequestOrgao $input)
    {
        $parameters = $this->systemParams->orgaoParams();

        $data = array_merge([
            'body' => ['cnpj' => $input->getDocumento()],
            'endpoint' => $parameters
        ]);

        $result = $this->httpService->put($data);

        if ($result->getStatusCode() === STATUS_CODE_NOT_FOUND) {
            return $this->output->unableUpdated($result->getBody()->getContents());
        }

        return $this->output->organ($result->getBody()->getContents());
    }

    private function orgaoCadastrado(string $documento): bool|string
    {
        $parameters = $this->systemParams->orgaoParams($documento);
        $result = $this->httpService->get($parameters);

        if ($result->getStatusCode() === STATUS_CODE_NOT_FOUND) {
            return false;
        }

        return $result->getBody()->getContents();
    }
}
