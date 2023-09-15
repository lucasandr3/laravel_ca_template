<?php

namespace App\Infra\Services;

use App\Infra\Database\Repositories\SystemParam;

class SystemParams
{
    public function sendPurchaseParams(): array
    {
        $array = [];

        $resources = [
            'HOST_PNCP',
            'LINK_SALA_DISPUTA_VISITANTE',
            'KEY_SALA_VISITANTE',
            'LINK_POST_COMPRAS'
        ];

        $parameters = SystemParam::query()->whereIn('campo', $resources)->get();

        foreach ($parameters as $parameter) {
            $array[$parameter->campo] = $parameter->valor;
        }

        return $array;
    }

    public function getAuthParams(): array
    {
        $array = [];

        $resources = [
            'HOST_PNCP',
            'LINK_LOGIN_PNCP',
            'AUTH_LOGIN',
            'AUTH_PASSWORD'
        ];

        $parameters = SystemParam::query()->whereIn('campo', $resources)->get();

        foreach ($parameters as $parameter) {
            $array[$parameter->campo] = $parameter->valor;
        }

        return $array;
    }
}
