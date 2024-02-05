<?php

namespace App\Infra\Services;

use App\Infra\Database\Repositories\SystemParam;
use Illuminate\Support\Fluent;

class SystemParams
{
    public function compraParams(Fluent $dados = null): array|string
    {
        $resources = [
            'LINK_SALA_DISPUTA_VISITANTE',
            'KEY_SALA_VISITANTE',
            'LINK_POST_COMPRAS',
            'LINK_DELETE_COMPRA'
        ];

        $parameters = $this->prepareParams($resources);

        if ($dados !== null) {
            $url = $parameters['HOST_PNCP'] . $parameters['LINK_DELETE_COMPRA'];
            return sprintf($url, $dados->cnpj, $dados->ano, $dados->sequencial);
        }

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

    public function contratoParams(int|null|string $cnpjOrgao = null, array $dados = [], array $arquivo = []): string
    {
        $resources = ['LINK_POST_CONTRATO', 'LINK_DEL_CONTRATO', 'LINK_ARQUIVO_CONTRATO'];
        $parameters = $this->prepareParams($resources);
        $hostPNCP = $parameters['HOST_PNCP'];

        if (filled($dados)) {
            return sprintf(
                $hostPNCP . $parameters['LINK_DEL_CONTRATO'],
                $dados['cnpj'], $dados['anoCompra'], $dados['sequencialContrato']
            );
        }

        if (filled($arquivo)) {
            return sprintf(
                $hostPNCP . $parameters['LINK_ARQUIVO_CONTRATO'],
                $arquivo['cnpj'], $arquivo['anoCompra'], $arquivo['sequencialContrato']
            );
        }

        return sprintf($parameters['HOST_PNCP'] . $parameters['LINK_POST_CONTRATO'], $cnpjOrgao);
    }

    public function arquivoParams(Fluent $dados = null, bool $delFile = false): array|string
    {
        $resources = ['LINK_POST_EDITAIS', 'LINK_DELETE_EDITAIS'];
        $parameters = $this->prepareParams($resources);

        if ($dados !== null && $delFile === false) {
            $url = $parameters['HOST_PNCP'] . $parameters['LINK_POST_EDITAIS'];
            return sprintf($url, $dados->cnpj, $dados->ano, $dados->sequencial);
        }

        if ($dados !== null && $delFile === true) {
            $url = $parameters['HOST_PNCP'] . $parameters['LINK_DELETE_EDITAIS'];
            return sprintf($url, $dados->cnpj, $dados->ano, $dados->sequencial, $dados->sequencialDocumento);
        }

        return $parameters;
    }

    public function itemParams(Fluent $dados = null, bool $item = false, bool $post = false, bool $result = false): array|string
    {
        $resources = ['LINK_GET_ITEMS', 'LINK_PUT_ITEMS', 'LINK_POST_ITEMS', 'LINK_POST_RESULTADO', 'LINK_PUT_RESULTADO'];
        $parameters = $this->prepareParams($resources);

        if ($dados !== null && $item === false && $result === false) {
            $isPost = $post ? $parameters['LINK_POST_ITEMS'] : $parameters['LINK_GET_ITEMS'];
            $url = $parameters['HOST_PNCP'] . $isPost;
            return sprintf($url, $dados->cnpj, $dados->ano, $dados->sequencial);
        }

        if ($dados !== null && $item === true && $result === false) {
            $url = $parameters['HOST_PNCP'] . $parameters['LINK_PUT_ITEMS'];
            return sprintf($url, $dados->cnpj, $dados->ano, $dados->sequencial, $dados->sequencialItem);
        }

        if ($dados !== null && $result === true) {

            if ($dados->sequencialResultado) {
                $url = $parameters['HOST_PNCP'] . $parameters['LINK_PUT_RESULTADO'];
                return sprintf($url, $dados->cnpj, $dados->ano, $dados->sequencial, $dados->sequencialItem, $dados->sequencialResultado);
            }

            $url = $parameters['HOST_PNCP'] . $parameters['LINK_POST_RESULTADO'];
            return sprintf($url, $dados->cnpj, $dados->ano, $dados->sequencial, $dados->sequencialItem);
        }

        return $parameters;
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
