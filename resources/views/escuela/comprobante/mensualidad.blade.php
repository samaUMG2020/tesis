<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Comprobante de Mensualidad</title>
    <style>
        body {
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            font-size: 11px;
            font-style: normal;
        }
        img {
			height:42px;
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
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center" width="20%" style="vertical-align: middle; color: red;">
                <h2>ORIGINAL</h2>
            </td>
            <td align="right" width="60%">
                <h3><strong>RECIBO NO. {{ $pago_alumno->id }}</strong></h3>
            </td>
        </tr>
        <tr>
            <td align="left" colspan="2">CICLO: {{ $pago_alumno->anio }}</td>
        </tr>
        <tr>
            <td align="left" colspan="2">ALUMNO: {{ $pago_alumno->alumno->nombre_completo }}</td>
        </tr>
        <tr>
            <td align="left" colspan="2">GRADO: {{ $pago_alumno->grado_seccion->grado->nombre }}</td>
        </tr>
        <tr>
            <td align="left" colspan="2">SECCION: {{ $pago_alumno->grado_seccion->seccion->nombre }}</td>
        </tr>
        <tr>
            <td align="left" colspan="2">TIPO DE PAGO: {{ $pago_alumno->tipo_pago_alumno->nombre }}</td>
        </tr>
        <tr>
            <td align="left" colspan="2">MES: {{ $pago_alumno->mes->nombre }}</td>
        </tr>
        <tr>
            <td align="left" colspan="2">MONTO: Q {{ number_format($pago_alumno->monto,2,'.',',') }}</td>
        </tr>
        <tr>
            <td align="left" colspan="2">FECHA DE PAGO: {{ date('d/m/Y' , strtotime($pago_alumno->created_at)) }}</td>
        </tr>
        <tr>
            <td align="right" colspan="2">
                Firma: ________________________________
                <br><br>
            </td>
        </tr>
    </table>
    <hr>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center" width="20%" style="vertical-align: middle; color: red;">
                <h2>COPIA</h2>
            </td>
            <td align="right" width="60%">
                <h3><strong>RECIBO NO. {{ $pago_alumno->id }}</strong></h3>
            </td>
        </tr>
        <tr>
            <td align="left" colspan="2">CICLO: {{ $pago_alumno->anio }}</td>
        </tr>
        <tr>
            <td align="left" colspan="2">ALUMNO: {{ $pago_alumno->alumno->nombre_completo }}</td>
        </tr>
        <tr>
            <td align="left" colspan="2">GRADO: {{ $pago_alumno->grado_seccion->grado->nombre }}</td>
        </tr>
        <tr>
            <td align="left" colspan="2">SECCION: {{ $pago_alumno->grado_seccion->seccion->nombre }}</td>
        </tr>
        <tr>
            <td align="left" colspan="2">TIPO DE PAGO: {{ $pago_alumno->tipo_pago_alumno->nombre }}</td>
        </tr>
        <tr>
            <td align="left" colspan="2">MES: {{ $pago_alumno->mes->nombre }}</td>
        </tr>
        <tr>
            <td align="left" colspan="2">MONTO: Q {{ number_format($pago_alumno->monto,2,'.',',') }}</td>
        </tr>
        <tr>
            <td align="left" colspan="2">FECHA DE PAGO: {{ date('d/m/Y' , strtotime($pago_alumno->created_at)) }}</td>
        </tr>
        <tr>
            <td align="right" colspan="2">
                Firma: ________________________________
                <br><br>
            </td>
        </tr>
    </table>
</body>
</html>