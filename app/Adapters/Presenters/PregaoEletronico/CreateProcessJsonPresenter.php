<?php

namespace App\Adapters\Presenters\PregaoEletronico;

use App\Domain\UseCases\PregaoEletronico\PregaoEletronicoOutput;
use Symfony\Component\HttpFoundation\JsonResponse;

class CreateProcessJsonPresenter implements PregaoEletronicoOutput
{
    public function created(): JsonResponse
    {
        return response()->json(['message' => 'Compra cadastrado com sucesso.']);
    }

    public function updated(): JsonResponse
    {
        return response()->json(['message' => 'Compra atualizada com sucesso.']);
    }

    public function deleted(): JsonResponse
    {
        return response()->json(['message' => 'Compra excluída com sucesso.']);
    }

    public function notFoundResource(): JsonResponse
    {
        return response()->json(['message' => 'Compra não encontrada.'], 404);
    }

    public function notFoundResourceInPncp(): JsonResponse
    {
        return response()->json(['message' => 'Compra não encontrada no PNCP.'], 404);
    }

    public function unableCreate(string $result): JsonResponse
    {
        return response()->json($this->prepareOutput($result));
    }

    public function unableUpdated(string $result)
    {
        return response()->json($this->prepareOutput($result));
    }

    public function unableDeleted(string $result)
    {
        return response()->json($this->prepareOutput($result));
    }

    public function process(string $process)
    {
        return response()->json($this->prepareOutput($process));
    }

    private function prepareOutput(string $output)
    {
        return json_decode($output);
    }
}
