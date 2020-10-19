<?php

namespace App\Http\Controllers\escuela\sistema;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use App\Models\escuela\sistema\AlumnoGrado;
use App\Models\escuela\catalogo\GradoSeccion;
use App\Models\escuela\sistema\Alumno;
use Illuminate\Support\Facades\DB;

class AlumnoGradoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('administrador');
        //$this->middleware('director');
        $this->middleware('secretaria')->only('destroy');
        $this->middleware('catedratico')->only('create', 'store', 'edit', 'update', 'destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $anio_actual = date('Y');
            $values = DB::table('grado_seccion')
            ->join('seccion', 'grado_seccion.seccion_id', 'seccion.id')
            ->join('grado', 'grado_seccion.grado_id', 'grado.id')
            ->join('carrera', 'grado.carrera_id', 'carrera.id')
            ->select(
                'grado_seccion.id AS id',
                DB::RAW('CONCAT(grado.nombre," ",carrera.nombre," - Sección ",seccion.nombre) AS nombre'),
                DB::RAW("(SELECT COUNT(*) FROM alumno_grado WHERE alumno_grado.grado_seccion_id = grado_seccion.id AND alumno_grado.anio = {$anio_actual}) AS cantidad")
            )
            ->where(DB::RAW('(SELECT COUNT(*) FROM curso_g_s WHERE curso_g_s.grado_seccion_id = grado_seccion.id)'), '>', 0)
            ->orderBy('grado.nombre')
            ->orderBy('seccion.nombre')
            ->get();

            return view('escuela.sistema.alumno_grado.index ', ['values' => $values]);
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('home')->with('danger', $th->getMessage());
            else
                return redirect()->route('home')->with('danger', $th->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\escuela\sistema\AlumnoGrado  $alumnoGrado
     * @return \Illuminate\Http\Response
     */
    public function show($alumnoGrado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\escuela\sistema\AlumnoGrado  $alumnoGrado
     * @return \Illuminate\Http\Response
     */
    public function edit(AlumnoGrado $alumnoGrado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\escuela\sistema\AlumnoGrado  $alumnoGrado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AlumnoGrado $alumnoGrado)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\escuela\sistema\AlumnoGrado  $alumnoGrado
     * @return \Illuminate\Http\Response
     */
    public function destroy(AlumnoGrado $alumnoGrado)
    {
        //
    }
}
