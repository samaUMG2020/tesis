<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\escuela\catalogo\Mes;
use App\Models\escuela\sistema\PagoAlumno;

class ComprobanteController extends Controller
{
    public function inscripcion(PagoAlumno $pago_alumno)
    {
        $pdf = \PDF::loadView('escuela.comprobante.inscripcion', compact('pago_alumno'));
        return $pdf->stream("comprobante_inscripcion_{$pago_alumno->id}.pdf");
    }

    public function mensualidad(PagoAlumno $pago_alumno)
    {
        $pdf = \PDF::loadView('escuela.comprobante.mensualidad', compact('pago_alumno'));
        return $pdf->stream("comprobante_mensualidad_{$pago_alumno->id}.pdf");
    }

    public function pago_catedratico(Mes $mes)
    {
        $anio_actual = date('Y');
        $pagos = DB::table('catedratico')
        ->select(
            'catedratico.id AS catedratico_id',
            'catedratico.nombre_completo AS nombre_completo',
            DB::RAW("(SELECT pago_catedratico.monto FROM pago_catedratico WHERE pago_catedratico.catedratico_id = catedratico.id AND pago_catedratico.mes_id = {$mes->id} AND pago_catedratico.anio = {$anio_actual}) AS monto")
        )
        ->where('catedratico.activo', true)
        ->get();

        $pdf = \PDF::loadView('escuela.comprobante.pago_catedratico', compact('pagos', 'mes', 'anio_actual'));
        return $pdf->stream("comprobante_pago_{$mes->id}_{$anio_actual}.pdf");
    }
}
