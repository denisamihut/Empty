<?php

namespace App\Http\Services\Billing;

use nusoap_client;


class Facturacion
{
    private $client;
    private $baseUrl;

    public function __construct(string $type)
    {
        $this->baseUrl = config('services.billing.' . $type . '.url');
        $this->client = new nusoap_client($this->baseUrl);
    }

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    public function getClient(): nusoap_client
    {
        return $this->client;
    }

    public function callClient(string $method, array $params): array
    {
        try {
            $result = $this->getClient()->call($method, $params);
            if ($this->getClient()->fault) {
                return [
                    'success' => false,
                    'message' => $this->facturacion->getClient()->fault
                ];
            } else {
                $error = $this->getClient()->getError();
                if ($error) {
                    return [
                        'success' => false,
                        'message' => $error
                    ];
                } else {
                    $result  = json_decode($result);
                    if ($result->code == '0') {
                        $file_ZIP_BASE64 = $result->fileZIPBASE64;
                        $nombre_documento = $result->nombre_documento;
                        $solicitudId = $result->id_solicitud;
                        $file_ZIP = base64_decode($file_ZIP_BASE64);
                        $filename_zip = storage_path('app/public/reportes/' . $nombre_documento . ".zip");
                        file_put_contents($filename_zip, $file_ZIP);
                        return [
                            'success' => true,
                            'message' => 'Se envio correctamente',
                            'solicitudId' => $solicitudId
                        ];
                    } else {
                        return [
                            'success' => false,
                            'message' => $result->message
                        ];
                    }
                }
            }
        } catch (\Exception $e) {
            $response = [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
        return $response;
    }
}