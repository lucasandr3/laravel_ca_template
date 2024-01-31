<?php

namespace App\Infra\Services;

use App\Models\External\EditalDocument;
use App\Models\External\Process;
use GuzzleHttp\Psr7\Utils;

class DocumentUtils
{
    public function preparePurchaseFirstDocumentImp(Process $process): array
    {
        $document = $process->notices()->first();

        $path = config('document.CONFIG_API_BUCKET') . DIRECTORY_SEPARATOR . $document->caminho;
        $filename = basename($path);
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        if (!in_array($extension, CONFIG_ARQUIVO_EXTENSOES, true)) {
            throw new \DomainException("Para enviar o processo para o PNCP e preciso que o processo tenha um edital.");
        }

        return [
            'Titulo-Documento' => truncate($filename, 45, 0, ".{$extension}"),
            'Tipo-Documento-Id' => getTypePurchaseDocument($process),
            'multipart' => [
                [
                    'name' => 'documento',
                    'contents' => Utils::tryFopen($path, 'r'),
                    'filename' => $filename
                ]
            ]
        ];
    }

    public function prepareDocumentImp(EditalDocument $document, Process $process): array
    {
        $path = config('document.CONFIG_API_BUCKET') . DIRECTORY_SEPARATOR . $document->caminho;
        $filename = basename($path);
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        if (!in_array($extension, CONFIG_ARQUIVO_EXTENSOES, true)) {
            throw new \DomainException("Para enviar o processo para o PNCP e preciso que o processo tenha um edital.");
        }

        return [
            'Titulo-Documento' => truncate($filename, 45, 0, ".{$extension}"),
            'Tipo-Documento-Id' => getTypePurchaseDocument($process),
            'multipart' => [
                [
                    'name' => 'arquivo',
                    'contents' => Utils::tryFopen($path, 'r'),
                    'filename' => $filename
                ]
            ]
        ];
    }
}
