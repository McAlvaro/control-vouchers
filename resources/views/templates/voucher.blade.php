<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voucher</title>
</head>

<style>
    @page {
        margin: 0.5cm 1cm 0.5cm 1cm;
    }

    body {
        font-size: 11pt;
    }

    #detail-table th,
    #detail-table td {
        border: 1px solid #000;
        padding: 2px;
        text-align: left;
        font-size: 11pt;
    }

    #detail-table td {
        text-align: center;
    }

    #detail-table td:nth-child(2) {
        text-align: left;
    }

    .signature {
        width: 200px;
        border-top: 1px solid #000;
        padding-top: 5px;
        text-align: center;
    }
</style>

<body>
    <div style="width: 100vw; text-align: center;">
        <table style="margin: 0 auto;">
            <tr>
                <td style="vertical-align: top; margin: 0;">
                    <div style="text-align: center; margin-right: 20px;">
                        <h3 style="display: block; padding: 2px 4px; margin: 0; margin-bottom: 2px; text-align: center;">VIAS BOLIVIA - REGIONAL TARIJA</h3>
                        <h3 style="display: block; padding: 2px 4px; margin: 0; margin-bottom: 2px; text-align: center;">VALE DE COMBUSTIBLE</h3>
                        <p style="display: block; padding: 2px 4px; margin: 0; margin-bottom: 2px; text-align: center;">Tarija, {{$data['date']}}</p>
                    </div>
                </td>
                <td style="vertical-align: top;">
                    <div>
                        <img src="{{$logo}}" alt="Logo" style="width: 200px; height: 60px;">
                        <div style="width: 180px; border: 1px solid black; text-align: center; margin-top: 10px;">
                            <h3 style="margin: 0;">{{$data['voucher_number']}}</h3>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <div style="text-align: left; padding-left: 20px; margin: 0;">
            <p style="display: block; padding: 2px 4px; margin: 0; margin-bottom: 2px;">
                <strong> Señores: </strong> <span style="font-weight: bold; margin-left: 10px; text-transform: uppercase;">{{$data['station_name']}}</span>
            </p>
            <p style="display: block; padding: 2px 4px; margin: 0;">
                <strong> Sirvase entregar a: </strong> <span style="font-weight: normal; margin-left: 10px; text-transform: uppercase;">{{$data['delivery_to']}}</span>
            </p>
            <p style="display: block; padding: 2px 4px; margin: 0;">
                <strong> Vehículo: </strong> <span style="font-weight: normal; margin-left: 75px; text-transform: uppercase;">{{$data['vehicle']}} {{$data['plate']}}</span>
            </p>
            <p style="display: block; padding: 2px 4px; margin: 0;">
                <strong> Kilometraje: </strong>
                <span style="font-weight: normal; margin-left: 55px; margin-right: 20px; text-transform: uppercase;">{{$data['kilometer']}} </span>
                de Propiedad de VIAS BOLIVIA Regional Tarija.
            </p>
            <p style="display: block; padding: 2px 4px; margin: 0;">
                <strong> Lo Siguiente: </strong>
            </p>
        </div>
        <table id="detail-table" style="width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px; padding: 10px 20px;">
            <tr>
                <th>CANTIDAD</th>
                <th>DESCRIPCION</th>
                <th>C/UNITARIO LITRO</th>
                <th>C/TOTAL Bs.-</th>
            </tr>
            @foreach($data['items'] as $item)
            <tr>
                <td>{{$item['quantity']}}</td>
                <td>{{$item['description']}}</td>
                <td>{{$item['unit_price']}}</td>
                <td>{{$item['total_price']}}</td>
            </tr>
            @endforeach
            <tr>
                <th colspan="3">TOTALES</th>
                <td style="text-align: center;">{{$data['total_amount']}}</td>
            </tr>
        </table>
        <div style="padding: 30px 20px; text-align: center;">
            <div style="float: left;" class="signature">RECIBI CONFORME</div>
            <div style="float: right;" class="signature">RESPONSABLE ADMINISTRATIVO</div>

            <div style="margin-top: 60px; margin-left: auto; margin-right: auto; display: block;" class="signature">JEFE REGIONAL</div>
        </div>
    </div>
    <div style="width: 100vw; text-align: center; margin-top: 20px;">
        <table style="margin: 0 auto;">
            <tr>
                <td style="vertical-align: top; margin: 0;">
                    <div style="text-align: center; margin-right: 20px;">
                        <h3 style="display: block; padding: 2px 4px; margin: 0; margin-bottom: 2px; text-align: center;">VIAS BOLIVIA - REGIONAL TARIJA</h3>
                        <h3 style="display: block; padding: 2px 4px; margin: 0; margin-bottom: 2px; text-align: center;">VALE DE COMBUSTIBLE</h3>
                        <p style="display: block; padding: 2px 4px; margin: 0; margin-bottom: 2px; text-align: center;">Tarija, {{$data['date']}}</p>
                    </div>
                </td>
                <td style="vertical-align: top;">
                    <div>
                        <img src="{{$logo}}" alt="Logo" style="width: 200px; height: 60px;">
                        <div style="width: 180px; border: 1px solid black; text-align: center; margin-top: 10px;">
                            <h3 style="margin: 0;">{{$data['voucher_number']}}</h3>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <div style="text-align: left; padding-left: 20px; margin: 0;">
            <p style="display: block; padding: 2px 4px; margin: 0; margin-bottom: 2px;">
                <strong> Señores: </strong> <span style="font-weight: bold; margin-left: 10px; text-transform: uppercase;">{{$data['station_name']}}</span>
            </p>
            <p style="display: block; padding: 2px 4px; margin: 0;">
                <strong> Sirvase entregar a: </strong> <span style="font-weight: normal; margin-left: 10px; text-transform: uppercase;">{{$data['delivery_to']}}</span>
            </p>
            <p style="display: block; padding: 2px 4px; margin: 0;">
                <strong> Vehículo: </strong> <span style="font-weight: normal; margin-left: 75px; text-transform: uppercase;">{{$data['vehicle']}} {{$data['plate']}}</span>
            </p>
            <p style="display: block; padding: 2px 4px; margin: 0;">
                <strong> Kilometraje: </strong>
                <span style="font-weight: normal; margin-left: 55px; margin-right: 20px; text-transform: uppercase;">{{$data['kilometer']}} </span>
                de Propiedad de VIAS BOLIVIA Regional Tarija.
            </p>
            <p style="display: block; padding: 2px 4px; margin: 0;">
                <strong> Lo Siguiente: </strong>
            </p>
        </div>
        <table id="detail-table" style="width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px; padding: 10px 20px;">
            <tr>
                <th>CANTIDAD</th>
                <th>DESCRIPCION</th>
                <th>C/UNITARIO LITRO</th>
                <th>C/TOTAL Bs.-</th>
            </tr>
            @foreach($data['items'] as $item)
            <tr>
                <td>{{$item['quantity']}}</td>
                <td>{{$item['description']}}</td>
                <td>{{$item['unit_price']}}</td>
                <td>{{$item['total_price']}}</td>
            </tr>
            @endforeach
            <tr>
                <th colspan="3">TOTALES</th>
                <td style="text-align: center;">{{$data['total_amount']}}</td>
            </tr>
        </table>
        <div style="padding: 30px 20px; text-align: center;">
            <div style="float: left;" class="signature">RECIBI CONFORME</div>
            <div style="float: right;" class="signature">RESPONSABLE ADMINISTRATIVO</div>

            <div style="margin-top: 60px; margin-left: auto; margin-right: auto; display: block;" class="signature">JEFE REGIONAL</div>
        </div>
    </div>
</body>

</html>
