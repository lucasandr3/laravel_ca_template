<?php

namespace App\Adapters\Presenters\Arquivo;

use App\Domain\UseCases\Arquivo\ArquivoOutput;
use Symfony\Component\HttpFoundation\JsonResponse;

class ArquivoJsonPresenter implements ArquivoOutput
{
    public function notFoundResource(): JsonResponse
    {
        return response()->json(['message' => 'Compra não encontrada.'], 404);
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
        return response()->json(['message' => 'Documento enviado com sucesso.']);
    }

    public function deleted(): JsonResponse
    {
        return response()->json(['message' => 'Documento ecxcluído com sucesso.']);
    }

    public function error(string $result): JsonResponse
    {
        return response()->json($this->prepareOutput($result));
    }

    public function arquivos(string $result)
    {
        return response()->json($this->prepareOutput($result));
    }

    private function prepareOutput(string $output)
    {
        return json_decode($output);
    }
}
