<?php

namespace App\Http\Services\Billing;

use App\Models\Billing;
use App\Models\BillingDetails;

class BillingService
{
    protected Facturacion $facturacion;
    protected string $type;

    public function __construct(string $type)
    {
        $this->facturacion = new Facturacion($type);
        $this->type = $type;
    }

    public function sendFactura(Billing $billing): array
    {
        $document = $this->getDocumentBody($billing);
        $params = $this->generateDataToSendFactura($document, $billing);
        return $this->facturacion->callClient('sendFactura', $params);
    }

    public function sendBoleta(Billing $billing)
    {
        $document = $this->getDocumentBody($billing);
        $params = $this->generateDataToSendFactura($document, $billing);
        return $this->facturacion->callClient('sendBoleta', $params);
    }

    private function generateDataToSendFactura(array $document, $billing): array
    {
        $json = [
            'token' => "",
            'seriefactura' => $document['seriefactura'],
            'correlativofactura' => $document['correlativofactura'],
            'doc' => "",
            'nombre' => $document['usuario'],
            'direccion' => $billing->client->address,
            'total' => $billing->total,
            'comprobante' => json_encode($document)
        ];
        $json = json_encode($json);

        return [
            'ruc' => '10723124871',
            'password' => '123456789',
            'json' => $json,
        ];
    }

    private function getDocumentBody(Billing $billing): array
    {
        $body = [
            "fechaemision" => date('Y-m-d', strtotime($billing->date)),
            "horaemision" => date('H:i:s', strtotime($billing->date)),
            "usuario" => $billing->client->full_name,
            "tipodoc" => $this->getIdType($billing->type),
            "moneda" => "PEN",
            "codubigeo" => '0000',
            "descuentototal" => 0,
            "motivodescuento" => "02",
            "percepcion" => "",
            "aplicacionpercepcion" => "",
            "documentosanexos" => [],
            "detalles" => $this->formatDetails($billing->details),
        ];
        if ($billing->type == 'BOLETA') {
            $document['numeroboleta'] = $this->getNumerBilling($billing->number);
            $document['dni'] = $billing->client->dni;
        } else if ($billing->type == 'FACTURA') {
            $body['numerofactura'] = $this->getNumerBilling($billing->number);
            $body['ruc'] = $billing->client->ruc;
        }
        return $body;
    }

    private function formatDetails(BillingDetails $details): array
    {
        $data = [];
        foreach ($details as $item) {
            $data[] = [
                'tipodetalle' => "V",
                'codigo' => "-",
                'unidadmedida' => "NIU",
                'cantidad' => $item->amount,
                'descripcion' => $item->product->name ?? $item->service->name,
                'precioventaunitarioxitem' => $item->price,
                'descuentoxitem' => 0,
                'tipoigv' => "10", // TO DO ESPCIFY
                'tasaisc' => "0",
                'aplicacionisc' => "",
                'precioventasugeridoxitem' => ""
            ];
        }
        return $data;
    }

    public function getIdType(string $type): int
    {
        switch ($type) {
            case 'BOLETA':
                return 1;
            case 'FACTURA':
                return 6;
            default:
                return 0;
        }
    }

    public function getNumerBilling(string $number): string
    {
        $data = explode("-", $number);
        $serie = substr($data[0], 1);
        $correlative = $data[1];
        return $serie . '-' . $correlative;
    }
}