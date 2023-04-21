<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $data['type'] }}</title>

    <style type="text/css">
        * {
            font-family: Verdana, Arial, sans-serif;
        }
        table{
            font-size: x-small;
        }
        tfoot tr td{
            font-weight: bold;
            font-size: x-small;
        }

        .gray {
            background-color: lightgray
        }
    </style>
</head>
<body>

  <table width="100%">
    <tr>
        {{-- <td valign="top"><img src="resources/150x150.png"/></td> --}}
        <td align="center">
            <h2>{{ $data['settings']['razon_social'] }}</h2>
        </td>
    </tr>
    <tr>
      <td align="center">
        <p>
          {{ $data['settings']['ruc'] }} <br>
          {{ $data['settings']['direccion'] }} <br>
          {{ $data['settings']['telefono'] }} <br>
          {{ $data['settings']['email'] }} <br>
        </p>
      </td>
    </tr>
  </table>
  <hr>
  @php
    $subtitle = 'Factura de Venta Electrónica';
    $document = $data['billing']['client']['ruc'];
    $details = $data['details'];
    if ($data['type'] == 'BOLETA') {
      $subtitle = 'Boleta de Venta Electrónica';
      $document = $data['billing']['client']['dni'];
    }else if ($data['type'] == 'TICKET') {
      $subtitle = 'Ticket de Venta';
      $document = $data['billing']['client']['dni'];
    }
  @endphp
  <table width="100%">
    <tr>
        <td align="center">
            <h3>
              {{ $subtitle }} <br>
              {{ $data['billing']['number'] }}
            </h3>
        </td>
    </tr>
  </table>
  <hr>
  <table width="100%">
    <tr>
        <td><strong>Fecha de Emisión:</strong> {{ $data['billing']['date'] }}</td>
    </tr>
    <tr>
      <td><strong>Cliente: </strong> {{ $data['billing']['client']['full_Name'] }}</td>
    </tr>
    <tr>
      <td><strong>Documento: </strong> {{ $document }}</td>
    </tr>
  </table>
  <br/>

  <table width="100%">
    <thead style="background-color: lightgray;">
      <tr>
        <th>{{ "Descripción" }}</th>
        <th>{{ "Cant." }}</th>
        <th>{{ "P. Unit" }}</th>
        <th>{{ "Total" }}</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($details as $item)
        <tr>
          <td>{{ isset($item['product_id']) ? $item['product']['name'] : $item['service']['name'] }}</td>
          <td align="right">{{ $item['amount'] }}</td>
          <td align="right">{{ $item['purchase_price'] }}</td>
          <td align="right">{{ $item['sale_price'] }}</td>
        </tr>  
      @endforeach
    </tbody>
    <br>
    <tfoot>
        <tr>
            <td colspan="2"></td>
            <td align="right">Op. Gravada: </td>
            <td align="right">{{ $data['billing']['subtotal'] }}</td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td align="right" >IGV: </td>
            <td align="right">{{ $data['billing']['igv'] }}</td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td align="right">Op. Inafecta: </td>
            <td align="right">0.00</td>
        </tr>
        <tr>
          <td colspan="2"></td>
          <td align="right">Op. Exonerada: </td>
          <td align="right">0.00</td>
        </tr>
        <tr>
          <td colspan="2"></td>
          <td align="right" class="gray">Importe Total: </td>
          <td align="right">{{ $data['billing']['total'] }}</td>
        </tr>
    </tfoot>
  </table>
  <br>
  @if ($data['type'] != 'TICKET')
  <div class="visible-print text-center">
    <p style="font-size: 0.6rem;">Representación impresa de la Factura Electrónica, consulte en https://facturae-garzasoft.com</p>
    <img style="height: 30px" src="data:image/png;base64, {!! base64_encode(QrCode::size(200)->generate($data['settings']['ruc'])) !!} ">
  </div>
  @endif
  @if ($data['type'] == 'TICKET')
  <div class="visible-print text-center">
    <p style="font-size: 0.6rem;">Esto no representa un comprobante electrónico válido.</p>
  </div>
  @endif

</body>
</html>