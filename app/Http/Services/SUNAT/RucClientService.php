<?php

namespace App\Http\Services\SUNAT;

use App\Librerias\HttpClient;

class RucClientService
{
    private $client;
    private string $url;

    public function __construct(HttpClient $cliente)
    {
        $this->client = $cliente->getClient();
        $this->url = config('services.sunat.url');
    }


    public function getClientByRuc(string $ruc): array
    {
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        $query_params = [
            'ruc' => $ruc,
            'fe' => config('services.sunat.fe'),
            'token' => config('services.sunat.token'),
        ];
        try {
            $request = $this->client->get($this->url, [
                'headers' => $headers,
                'query' => $query_params,
            ]);
            if ($request->getStatusCode() === 200) {
                $response = json_decode($request->getBody()->getContents(), true);
                if ($response['code'] === 0) {
                    return [
                        'success' => true,
                        'data' => $response,
                    ];
                }
                return [
                    'success' => false,
                    'data' => $response,
                ];
            }
            return [
                'success' => false,
                'data' => [],
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}