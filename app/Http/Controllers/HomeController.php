<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\AlumnosInscritos;
use App\Charts\PagosMensuales;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $anio_actual = date('Y');
        $inscritos_label = DB::table('grado_seccion')
        ->join('seccion', 'grado_seccion.seccion_id', 'seccion.id')
        ->join('grado', 'grado_seccion.grado_id', 'grado.id')
        ->join('carrera', 'grado.carrera_id', 'carrera.id')
        ->select(DB::RAW('CONCAT(grado.nombre," ",carrera.nombre," - Sección ",seccion.nombre) AS nombre'))
        ->orderBy('grado.nombre')
        ->orderBy('seccion.nombre')
        ->pluck('nombre');

        $inscritos_data = DB::table('grado_seccion')
        ->join('seccion', 'grado_seccion.seccion_id', 'seccion.id')
        ->join('grado', 'grado_seccion.grado_id', 'grado.id')
        ->join('carrera', 'grado.carrera_id', 'carrera.id')
        ->select(
            DB::RAW("(SELECT COUNT(*) FROM alumno_grado WHERE alumno_grado.grado_seccion_id = grado_seccion.id AND alumno_grado.anio = {$anio_actual}) AS cantidad")
        )
        ->orderBy('grado.nombre')
        ->orderBy('seccion.nombre')
        ->pluck('cantidad');

        $grafica_inscritos = $this->generar_pie($inscritos_label, 'alumnos_inscritos', 'Cantidad inscritos', $inscritos_data);

        $pagos_mes_label = DB::table('mes')
        ->select('mes.nombre AS nombre')
        ->where('mes.id', '!=', 13)
        ->orderBy('mes.id')
        ->pluck('nombre');

        $pagos_mes_data = DB::table('mes')
        ->select(
            DB::RAW("(SELECT COUNT(*) FROM pago_alumno WHERE pago_alumno.mes_id = mes.id AND pago_alumno.anio = {$anio_actual}) AS cantidad")
        )
        ->where('mes.id', '!=', 13)
        ->orderBy('mes.id')
        ->pluck('cantidad');

        $grafica_pagos_mes = $this->generar_bar($pagos_mes_label, 'Cantidad de pagos', $pagos_mes_data);

        $cursos_catedraticos_label = DB::table('catedratico')
        ->select('catedratico.nombre_completo AS nombre')
        ->where('catedratico.activo', true)
        ->orderBy('catedratico.id')
        ->pluck('nombre');

        $cursos_catedraticos_data = DB::table('catedratico')
        ->select(
            DB::RAW("(SELECT COUNT(*) FROM catedratico_curso WHERE catedratico_curso.catedratico_id = catedratico.id AND catedratico_curso.activo = 1) AS cantidad")
        )
        ->where('catedratico.activo', true)
        ->orderBy('catedratico.id')
        ->pluck('cantidad');

        $grafica_cursos_catedraticos = $this->generar_bar($cursos_catedraticos_label, 'Cantidad de cursos', $cursos_catedraticos_data);


        return view('home', compact('grafica_inscritos', 'grafica_pagos_mes', 'grafica_cursos_catedraticos'));
    }

    protected function generar_line($label, $legend, $data)
    {
        $chart = new PagosMensuales;
        $chart->labels($label);
        $chart->dataset($legend, 'line', $data);

        return $chart;
    }

    protected function generar_bar($label, $legend, $data)
    {
        $chart = new PagosMensuales;
        $chart->labels($label);
        $chart->dataset($legend, 'bar', $data);

        return $chart;
    }

    protected function generar_pie($label, $export, $legend, $data)
    {
        $chart = new AlumnosInscritos();
        $chart->labels($label);
        $chart->minimalist(true);
        $chart->tooltip(true);
        $chart->export(true, $export);
        $chart->dataset($legend, 'pie', $data)->options([
            'color' => $this->color_rand(count($label)),
        ]);

        return $chart;
    }

    protected function color_rand($cantidad)
    {
        $array = array();

        for ($i=0; $i < $cantidad+1; $i++) { 
            array_push($array, sprintf('#%06X', mt_rand(0, 0xFFFFFF)));
        }

        return $array;
    }
}
