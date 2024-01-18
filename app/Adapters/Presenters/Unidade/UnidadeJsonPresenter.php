<?php

namespace App\Adapters\Presenters\Unidade;

use App\Domain\UseCases\Unidade\UnidadeOutput;
use App\Http\Resources\Unidade\UnidadeResource;
use Symfony\Component\HttpFoundation\JsonResponse;

class UnidadeJsonPresenter implements UnidadeOutput
{
    public function todasUnidades(string $unidades): JsonResponse
    {
        return response()->json(UnidadeResource::make($this->prepareOutput($unidades)));
    }

    public function unidade(string $unidade): JsonResponse
    {
        return response()->json($this->prepareOutput($unidade));
    }

    public function notFoundResource(string $result): JsonResponse
    {
        return response()->json($this->prepareOutput($result));
    }

    public function unableCreate(string $result): JsonResponse
    {
        return response()->json($this->prepareOutput($result));
    }

    public function unableUpdated(string $result)
    {
        return response()->json($this->prepareOutput($result));
    }

    private function prepareOutput(string $output)
    {
        return json_decode($output);
    }
}
