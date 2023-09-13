<?php

namespace App\Infra\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class HttpService
{
    public function post($data): void
    {
        $response = Http::withHeaders([
            'Authorization' => "Bearer ",
            'Content-Type' => 'application/json'
        ])->post("{$this->params('ENDPOINT_TCE_RONDONIA')}/api/Licitacao/enviar", $data->jsonSerialize()['process']);
    }

    public function postWithDocument($data, $endpoint, $document): Response
    {
        return Http::post($endpoint, [
            'headers' => [
                'Authorization' => 'autorizarion',
                'Titulo-Documento' => $document['Titulo-Documento'],
                'Tipo-Documento-Id' => $document['Tipo-Documento-Id'],
            ],
            'multipart' => [
                [
                    'name' => 'compra',
                    'contents' => json_encode($data),
                    'headers' => ['Content-Type' => "application/json"]
                ],
                [
                    'name' => 'documento',
                    'contents' => $document['multipart'][0]['contents'],
                    'filename' => $document['multipart'][0]['filename'],
                    'headers' => ['Content-Type' => "multipart/form-data; boundary=-----44cf242ea3173cfa0b97f80c68608c4c'"]
                ]
            ]
        ]);
    }

    public function get($data, string $status): void
    {
        $response = Http::withHeaders([
            'Authorization' => "Bearer ",
            'Content-Type' => 'application/json'
        ])->get("{$this->params('ENDPOINT_TCE_RONDONIA')}/api/Licitacao/enviar", $data->jsonSerialize()['process']);
    }

    public function put($data, string $status): void
    {
        $response = Http::withHeaders([
            'Authorization' => "Bearer ",
            'Content-Type' => 'application/json'
        ])->put("{$this->params('ENDPOINT_TCE_RONDONIA')}/api/Licitacao/enviar", $data->jsonSerialize()['process']);
    }

    public function delete($data, string $status): void
    {
        $response = Http::withHeaders([
            'Authorization' => "Bearer ",
            'Content-Type' => 'application/json'
        ])->delete("{$this->params('ENDPOINT_TCE_RONDONIA')}/api/Licitacao/enviar", $data->jsonSerialize()['process']);
    }
}
