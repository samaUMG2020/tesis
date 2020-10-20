<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    public function inscripcion_view(Request $request)
    {
        $anio = '';

        if(isset($request->anio) && !empty($request->anio) && !is_null($request->anio)) {
            $this->validate(
                $request,
                [
                    'anio' => 'required|digits:4'
                ],
                [
                    'anio.required' => 'El año es obligatorio',
                    'anio.digits' => 'El año no tiene el formato de :value digitos'
                ]
            );

            $anio = $request->anio;
        }

        $data = DB::table('pago_alumno')
        ->join('alumno', 'pago_alumno.alumno_id', 'alumno.id')
        ->join('mes', 'pago_alumno.mes_id', 'mes.id')
        ->join('grado_seccion', 'pago_alumno.grado_seccion_id', 'grado_seccion.id')
        ->join('seccion', 'grado_seccion.seccion_id', 'seccion.id')
        ->join('grado', 'grado_seccion.grado_id', 'grado.id')
        ->join('carrera', 'grado.carrera_id', 'carrera.id')
        ->select(
            'alumno.nombre_completo AS alumno',
            DB::RAW('CONCAT(grado.nombre," ",carrera.nombre," - ",seccion.nombre) AS nombre'),
            DB::RAW('CONCAT("Q ",FORMAT(pago_alumno.monto,2)) AS monto'),
            'pago_alumno.anio AS anio',
            DB::RAW('DATE_FORMAT(pago_alumno.created_at, "%d/%m/%Y") AS fecha')
            )
            ->where('pago_alumno.mes_id', 13)
        ->where('pago_alumno.anio',$anio)
        ->orderByDesc('pago_alumno.anio')
        ->orderByDesc('grado.nombre')
        ->orderByDesc('carrera.nombre')
        ->orderByDesc('seccion.nombre')
        ->paginate(15);
        
        return view('escuela.reporte.inscripcion_view', compact('data', 'anio'));
    }

    public function inscripcion_report($anio)
    {
        $data = DB::table('pago_alumno')
        ->join('alumno', 'pago_alumno.alumno_id', 'alumno.id')
        ->join('mes', 'pago_alumno.mes_id', 'mes.id')
        ->join('grado_seccion', 'pago_alumno.grado_seccion_id', 'grado_seccion.id')
        ->join('seccion', 'grado_seccion.seccion_id', 'seccion.id')
        ->join('grado', 'grado_seccion.grado_id', 'grado.id')
        ->join('carrera', 'grado.carrera_id', 'carrera.id')
        ->select(
            'alumno.nombre_completo AS alumno',
            DB::RAW('CONCAT(grado.nombre," ",carrera.nombre," - ",seccion.nombre) AS nombre'),
            DB::RAW('CONCAT("Q ",FORMAT(pago_alumno.monto,2)) AS monto'),
            'pago_alumno.anio AS anio',
            DB::RAW('DATE_FORMAT(pago_alumno.created_at, "%d/%m/%Y") AS fecha')
            )
            ->where('pago_alumno.mes_id', 13)
            ->where('pago_alumno.anio', $anio)
            ->orderByDesc('pago_alumno.anio')
            ->orderByDesc('grado.nombre')
            ->orderByDesc('carrera.nombre')
            ->orderByDesc('seccion.nombre')
            ->get();

        $pdf = \PDF::loadView('escuela.reporte.inscripcion_report', compact('data', 'anio'));
        return $pdf->stream("reporte_inscripciones_{$anio}.pdf");
    }

    public function mensualidad_view(Request $request)
    {
        $anio = '';

        if (isset($request->anio) && !empty($request->anio) && !is_null($request->anio)) {
            $this->validate(
                $request,
                [
                    'anio' => 'required|digits:4'
                ],
                [
                    'anio.required' => 'El año es obligatorio',
                    'anio.digits' => 'El año no tiene el formato de :value digitos',
                    'anio.digits_between' => 'El año tiene que ser mayor a :min y menor a :max'
                ]
            );

            $anio = $request->anio;
        }

        $data = DB::table('pago_alumno')
        ->join('alumno', 'pago_alumno.alumno_id', 'alumno.id')
        ->join('mes', 'pago_alumno.mes_id', 'mes.id')
        ->join('grado_seccion', 'pago_alumno.grado_seccion_id', 'grado_seccion.id')
        ->join('seccion', 'grado_seccion.seccion_id', 'seccion.id')
        ->join('grado', 'grado_seccion.grado_id', 'grado.id')
        ->join('carrera', 'grado.carrera_id', 'carrera.id')
        ->select(
            'alumno.nombre_completo AS alumno',
            DB::RAW('CONCAT(grado.nombre," ",carrera.nombre," - ",seccion.nombre) AS nombre'),
            DB::RAW('CONCAT("Q ",FORMAT(pago_alumno.monto,2)) AS monto'),
            'pago_alumno.anio AS anio',
            DB::RAW('DATE_FORMAT(pago_alumno.created_at, "%d/%m/%Y") AS fecha'),
            'mes.nombre AS mes'
        )
        ->where('pago_alumno.mes_id', '!=', 13)
        ->where('pago_alumno.anio', $anio)
        ->orderByDesc('pago_alumno.anio')
        ->orderByDesc('pago_alumno.mes_id')
        ->orderByDesc('grado.nombre')
        ->orderByDesc('carrera.nombre')
        ->orderByDesc('seccion.nombre')
        ->paginate(15);

        return view('escuela.reporte.mensualidad_view', compact('data', 'anio'));
    }

    public function mensualidad_report($anio)
    {
        $data = DB::table('pago_alumno')
        ->join('alumno', 'pago_alumno.alumno_id', 'alumno.id')
        ->join('mes', 'pago_alumno.mes_id', 'mes.id')
        ->join('grado_seccion', 'pago_alumno.grado_seccion_id', 'grado_seccion.id')
        ->join('seccion', 'grado_seccion.seccion_id', 'seccion.id')
        ->join('grado', 'grado_seccion.grado_id', 'grado.id')
        ->join('carrera', 'grado.carrera_id', 'carrera.id')
        ->select(
            'alumno.nombre_completo AS alumno',
            DB::RAW('CONCAT(grado.nombre," ",carrera.nombre," - ",seccion.nombre) AS nombre'),
            DB::RAW('CONCAT("Q ",FORMAT(pago_alumno.monto,2)) AS monto'),
            'pago_alumno.anio AS anio',
            DB::RAW('DATE_FORMAT(pago_alumno.created_at, "%d/%m/%Y") AS fecha'),
            'mes.nombre AS mes'
            )
            ->where('pago_alumno.mes_id', '!=', 13)
            ->where('pago_alumno.anio', $anio)
            ->orderByDesc('pago_alumno.mes_id')
            ->orderByDesc('grado.nombre')
            ->orderByDesc('carrera.nombre')
            ->orderByDesc('seccion.nombre')
            ->get();

        $pdf = \PDF::loadView('escuela.reporte.mensualidad_report', compact('data', 'anio'));
        return $pdf->stream("reporte_mensualidades_{$anio}.pdf");
    }
}
