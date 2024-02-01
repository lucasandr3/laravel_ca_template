<?php

namespace App\Adapters\Presenters\Item;

use App\Domain\UseCases\Item\ItemOutput;
use Symfony\Component\HttpFoundation\JsonResponse;

class ItemJsonPresenter implements ItemOutput
{
    public function notFoundResource(): JsonResponse
    {
        return response()->json(['message' => 'Compra não encontrada.'], 404);
    }

    public function notFoundPurchaseResource(): JsonResponse
    {
        return response()->json(['message' => 'Compra não encontrada.'], 404);
    }

    public function notFoundExternalResource(): JsonResponse
    {
        return response()->json(['message' => 'Processo Externo não encontrado.'], 404);
    }

    public function notFoundFileResource(): JsonResponse
    {
        return response()->json(['message' => 'Documento não encontrado.'], 404);
    }

    public function unableUploaded(string $result): JsonResponse
    {
        return response()->json($this->prepareOutput($result), 422);
    }

    public function unableDeleted(string $result): JsonResponse
    {
        return response()->json($this->prepareOutput($result));
    }

    public function success(): JsonResponse
    {
        return response()->json(['message' => 'Item atualizado com sucesso.']);
    }

    public function successPostResult(): JsonResponse
    {
        return response()->json(['message' => 'Resultado enviado com sucesso.']);
    }

    public function created(): JsonResponse
    {
        return response()->json(['message' => 'Items cadastrados com sucesso.']);
    }

    public function deleted(): JsonResponse
    {
        return response()->json(['message' => 'Documento ecxcluído com sucesso.']);
    }

    public function error(string $result): JsonResponse
    {
        return response()->json($this->prepareOutput($result));
    }

    public function itens(string $result)
    {
        return response()->json($this->prepareOutput($result));
    }

    private function prepareOutput(string $output)
    {
        return json_decode($output);
    }
}
