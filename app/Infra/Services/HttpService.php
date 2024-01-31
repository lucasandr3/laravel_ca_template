<?php

namespace App\Infra\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Http;
use Psr\Http\Message\ResponseInterface;
use stdClass;

class HttpService
{
    public function post($data, bool $requiredAuthorization = false)
    {
        $client = new Client();
        $headers = [];

        if ($requiredAuthorization) {
            $authorization = $this->getAuthorizationImp();
            $headers['Authorization'] = $authorization->authorization;
        }

        try {

            $response = $client->request('post', $data['endpoint'], [
                'headers' => $headers,
                'json' => $data['body'],
            ]);

        } catch (RequestException $requestException) {
            return $requestException->getResponse();
        }

        return $response;
    }

    public function postWithDocument($data, $parameters, $document): bool|ResponseInterface
    {
        $authorization = $this->getAuthorizationImp();
        $endpoint = $parameters['HOST_PNCP'] . sprintf(
                $parameters['LINK_POST_COMPRAS'],
                $data->getCnpj()
            );

        try {
            $reponse = (new Client())->request('post', $endpoint, [
                'headers' => [
                    'Authorization' => $authorization->authorization,
                    'Titulo-Documento' => $document['Titulo-Documento'],
                    'Tipo-Documento-Id' => $document['Tipo-Documento-Id'],
                ],
                'multipart' => [
                    [
                        'name' => 'compra',
                        'contents' => $data->toJson(),
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
        } catch (RequestException $requestException) {
            echo "<pre>"; var_dump($requestException->getResponse()->getBody()->getContents()); echo "</pre>"; die;
        }

        return $reponse;
    }

    public function postDocument($document, $parameters): bool|ResponseInterface
    {
        $authorization = $this->getAuthorizationImp();

        try {
            $reponse = (new Client())->request('POST', $parameters, [
                'headers' => [
                    'Authorization' => $authorization->authorization,
                    'Titulo-Documento' => $document['Titulo-Documento'],
                    'Tipo-Documento-Id' => $document['Tipo-Documento-Id'],
                ],
                'multipart' => [
                    [
                        'name' => 'arquivo',
                        'contents' => $document['multipart'][0]['contents'],
                        'filename' => $document['multipart'][0]['filename'],
                    ]
                ]
            ]);
        } catch (RequestException $requestException) {
            return $requestException->getResponse();
        }

        return $reponse;
    }

    public function get($data)
    {
        $authorization = $this->getAuthorizationImp();

        try {

            $response = (new Client())->request('GET', $data, [
                'headers' => ['Authorization' => $authorization->authorization]
            ]);

        } catch (RequestException $requestException) {
            return $requestException->getResponse();
        }

        return $response;
    }

    public function put($data)
    {
        $authorization = $this->getAuthorizationImp();

        try {

            $response = (new Client())->request('put', $data['endpoint'], [
                'headers' => ['Authorization' => $authorization->authorization],
                'json' => $data['body']
            ]);

        } catch (RequestException $requestException) {
            return $requestException->getResponse();
        }

        return $response;
    }

    public function delete($data, string $reason = null)
    {
        $authorization = $this->getAuthorizationImp();

        try {

            $response = (new Client())->request('DELETE', $data, [
                'headers' => ['Authorization' => $authorization->authorization],
                'json' => ['justificativa' => $reason]
            ]);

        } catch (RequestException $requestException) {
            return $requestException->getResponse();
        }

        return $response;
    }

    private function getAuthorizationImp(): stdClass
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
