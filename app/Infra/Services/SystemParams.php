<?php

namespace App\Infra\Services;

use App\Infra\Database\Repositories\SystemParam;

class SystemParams
{
    public function sendPurchaseParams(): array
    {
        $resources = [
            'LINK_SALA_DISPUTA_VISITANTE',
            'KEY_SALA_VISITANTE',
            'LINK_POST_COMPRAS'
        ];

        return $this->prepareParams($resources);
    }

    /**
     * @param int|null|string $codigoOuDocumento
     * @return string
     */
    public function orgaoParams(int|null|string $codigoOuDocumento = null, array $filtro = []): string
    {
        $resources = [
            'LINK_POST_ORGAO',
            'LINK_GET_ORGAO'
        ];

        $parameters = $this->prepareParams($resources);

        if ($codigoOuDocumento !== null) {

            if (is_string($codigoOuDocumento)) {
                $url = $parameters['HOST_PNCP'] . $parameters['LINK_GET_ORGAO'];
                return sprintf($url, $codigoOuDocumento);
            }

            if (is_int($codigoOuDocumento)) {
                $url = $parameters['HOST_PNCP'] . $parameters['LINK_GET_ORGAO'];
                return str_replace('%s', "id/{$codigoOuDocumento}", $url);
            }
        }

        if (!empty($filtro)) {
            $query = http_build_query($filtro);
            return $parameters['HOST_PNCP'] . $parameters['LINK_POST_ORGAO'] . "/?" . $query;
        }

        return $parameters['HOST_PNCP'] . $parameters['LINK_POST_ORGAO'];
    }

    public function unidadeParams(int|null|string $cnpjOrgao = null, int|null|string $codigoOuDocumento = null, array $filtro = []): string
    {
        $resources = ['LINK_GET_UNIDADES', 'LINK_GET_UNIDADE', 'LINK_POST_UNIDADES'];

        $parameters = $this->prepareParams($resources);

        if ($codigoOuDocumento !== null) {
            if (is_string($codigoOuDocumento)) {
                $url = $parameters['HOST_PNCP'] . $parameters['LINK_GET_UNIDADES'];
                return sprintf($url, $codigoOuDocumento);
            }

            if (is_int($codigoOuDocumento)) {
                $url = $parameters['HOST_PNCP'] . $parameters['LINK_GET_UNIDADE'];
                return sprintf($url, $cnpjOrgao, $codigoOuDocumento);
            }
        }

        if ($cnpjOrgao !== null) {
            $url = $parameters['HOST_PNCP'] . $parameters['LINK_GET_UNIDADES'];
            return sprintf($url, $cnpjOrgao);
        }

        if (!empty($filtro)) {
            $query = http_build_query($filtro);
            return $parameters['HOST_PNCP'] . $parameters['LINK_POST_ORGAO'] . "/?" . $query;
        }

        return sprintf($parameters['HOST_PNCP'] . $parameters['LINK_POST_UNIDADES'], $cnpjOrgao);
    }

    public function contratoParams(int|null|string $cnpjOrgao = null)
    {
        $resources = ['LINK_POST_CONTRATO'];
        $parameters = $this->prepareParams($resources);

        return sprintf($parameters['HOST_PNCP'] . $parameters['LINK_POST_CONTRATO'], $cnpjOrgao);
    }

    public function getAuthParams(): array
    {
        $array = [];

        $resources = [
            'LINK_LOGIN_PNCP',
            'AUTH_LOGIN',
            'AUTH_PASSWORD'
        ];

        return $this->prepareParams($resources);
    }


    /**
     * @param array $resources
     * @return array
     */
    private function prepareParams(array $resources): array
    {
        $array = [];

        $resources[] = 'HOST_PNCP';

        $parameters = SystemParam::query()->whereIn('campo', $resources)->get();

        foreach ($parameters as $parameter) {
            $array[$parameter->campo] = $parameter->valor;
        }

        return $array;
    }
}
