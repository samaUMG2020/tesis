<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Comprobante de Inscripción</title>
    <style>
        body {
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            font-size: 11px;
            font-style: normal;
        }
        table { 
            border-style: solid; 
            border-top-width: 3px; 
            border-right-width: 3px; 
            border-bottom-width: 3px; 
            border-left-width: 3px;
            border-color: black;
            border-spacing: 0;
            border-collapse: collapse;
        } 
        td {
            padding-left: 20px;
            padding-right: 20px;
            padding-bottom: 5px;
            vertical-align: middle;
        }
    </style>
</head>
<body style="text-transform: uppercase;">
    <head align="center">
        <h3>Pagos para el mes de <strong>{{ $mes->nombre }} - {{ $anio_actual }}</strong></h3>
    </head>
    <table width="100%">
        <thead>
            <tr>
                <th align="center">Catedrático</th>
                <th align="center">Monto</th>
                <th align="center">Firma</th>
            </tr>
        </thead>
        <tbody>
            @if($pagos->count())  
                @foreach($pagos as $value)  
                <tr>
                    <td align="left">{{$value->nombre_completo}}</td>
                    <td align="right">Q {{ number_format($value->monto,2,'.',',') }}</td>   
                    <td align="right">___________________________________</td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</body>
</html>