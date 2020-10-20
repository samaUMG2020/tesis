<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        body {
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            font-size: 9px;
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
        <h3>Listado de Inscripciones del Año <strong>{{ $anio }}</strong></h3>
    </head>
    <table width="100%">
        <thead>
            <tr>
                <th>Año</th>
                <th>Alumno</th>
                <th>Grado y Sección</th>
                <th>Monto</th>
                <th>Fecha de Pago</th>
            </tr>
        </thead>
        <tbody>
            @if($data->count())  
                @foreach($data as $value)  
                <tr>
                    <td align="center">{{$value->anio}}</td>
                    <td align="left">{{$value->alumno}}</td>
                    <td align="left">{{$value->nombre}}</td>
                    <td align="right">{{$value->monto}}</td>
                    <td align="center">{{$value->fecha}}</td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</body>
</html>