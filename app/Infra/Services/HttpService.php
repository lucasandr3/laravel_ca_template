<?php

namespace App\Infra\Services;

use GuzzleHttp\Client;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use stdClass;

class HttpService
{
    public function post($data): void
    {
        $response = Http::withHeaders([
            'Authorization' => "Bearer ",
            'Content-Type' => 'application/json'
        ])->post("{$this->params('ENDPOINT_TCE_RONDONIA')}/api/Licitacao/enviar", $data->jsonSerialize()['process']);
    }

    public function postWithDocument($data, $parameters, $document)
    {
        $authorization = $this->getAuthorizationImp();
        $endpoint = $parameters['HOST_PNCP'] . sprintf(
                $parameters['LINK_POST_COMPRAS'],
                $data->getCnpj()
            );

//        $client = new Client();
//
//           $response = $client->request('post', $endpoint, [
//                'headers' => [
//                    'Authorization' => $authorization->authorization,
//                    'Titulo-Documento' => $document['Titulo-Documento'],
//                    'Tipo-Documento-Id' => $document['Tipo-Documento-Id'],
//                ],
//                'multipart' => [
//                    [
//                        'name' => 'compra',
//                        'contents' => $data->toJson(),
//                        'headers' => ['Content-Type' => "application/json"]
//                    ],
//                    [
//                        'name' => 'documento',
//                        'contents' => $document['multipart'][0]['contents'],
//                        'filename' => $document['multipart'][0]['filename'],
//                        'headers' => ['Content-Type' => "multipart/form-data; boundary=-----44cf242ea3173cfa0b97f80c68608c4c'"]
//                    ]
//                ]
//            ]);



        try {
            return Http::post($endpoint, [
                'headers' => [
                    'Authorization' => $authorization->authorization,
                    'Titulo-Documento' => $document['Titulo-Documento'],
                    'Tipo-Documento-Id' => $document['Tipo-Documento-Id'],
                ],
                'multipart' => [
                    [
                        'name' => 'compra',
                        'contents' => $data->toJson(),
                    ],
                    [
                        'name' => 'documento',
                        'contents' => $document['multipart'][0]['contents'],
                        'filename' => $document['multipart'][0]['filename'],
                        'headers' => ['Content-Type' => "multipart/form-data; boundary=-----44cf242ea3173cfa0b97f80c68608c4c'"]
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            echo "<pre>"; var_dump($e->getMessage()); echo "</pre>"; die;
        }
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

    function getAuthorizationImp(): stdClass
    {
        $systemParams = new SystemParams();
        $parameters = $systemParams->getAuthParams();

        $endpoint = $parameters['HOST_PNCP'] . $parameters['LINK_LOGIN_PNCP'];

        $response = Http::post($endpoint, [
            "login" => $parameters['AUTH_LOGIN'],
            "senha" => $parameters['AUTH_PASSWORD']
        ]);

        $result = new stdClass();
        $result->status = $response->status();
        $result->authorization = $response->status() != STATUS_CODE_OK
            ? json_decode($response->body())->message
            : $response->header('authorization');
        return $result;
    }
}
