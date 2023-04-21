<?php

namespace App\Http\Services;

use App\Http\Services\RENIEC\DniClientService;
use App\Http\Services\SUNAT\RucClientService;

class SearchClientService
{
    private string $documentType;
    private string $documentNumber;
    private DniClientService $dniClientService;
    private RucClientService $rucClientService;

    public function __construct(string $documentType, string $documentNumber)
    {
        $this->documentType = $documentType;
        $this->documentNumber = $documentNumber;
        $this->dniClientService = resolve(DniClientService::class);
        $this->rucClientService = resolve(RucClientService::class);
    }

    public function searchClient(): array
    {
        if ($this->documentType === 'DNI') {
            $response =  $this->dniClientService->getClientByDNI($this->documentNumber);
            if ($response['success']) {
                return [
                    'success' => true,
                    'data' => [
                        'name' => $response['data']['nombres'] . ' ' . $response['data']['apepat'] . ' ' . $response['data']['apemat'],
                        'ubigeo' => $response['data']['ubigeo'],
                        'birthday' => $response['data']['fecnac'],
                        'address' => '',
                    ]
                ];
            }
        }
        if ($this->documentType === 'RUC') {
            $response =  $this->rucClientService->getClientByRuc($this->documentNumber);
            if ($response['success']) {
                return [
                    'success' => true,
                    'data' => [
                        'name' => $response['data']['RazonSocial'],
                        'type' => $response['data']['Tipo'],
                        'address' => $response['data']['Direccion'],
                    ]
                ];
            }
        }
        return [
            'success' => false,
            'message' => 'Ha Ocurrido un error al buscar el cliente',
        ];
    }
}