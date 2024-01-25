<?php

namespace App\Adapters\Presenters\Contrato;

use App\Domain\UseCases\Contrato\ContratoOutput;
use Symfony\Component\HttpFoundation\JsonResponse;

class ContratoJsonPresenter implements ContratoOutput
{
    public function contrato(string $contrato): JsonResponse
    {
        return response()->json($this->prepareOutput($contrato));
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
