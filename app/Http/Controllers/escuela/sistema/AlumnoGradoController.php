<?php

namespace App\Http\Controllers\escuela\sistema;

use App\Http\Controllers\Controller;
use App\Models\escuela\catalogo\GradoSeccion;
use App\Models\escuela\sistema\Alumno;
use App\Models\escuela\sistema\AlumnoGrado;
use Illuminate\Http\Request;

class AlumnoGradoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$values = AlumnoGrado::with('grado_seccion.grado.carrera', 'alumno', 'grado_seccion.seccion')->get();
        $values = AlumnoGrado::get();
        return response()->json(['Registro nuevo' => $values, 'Mensaje' => 'Felicidades Consultaste']);
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
        $grado_seccion = GradoSeccion::find($request->grado_seccion_id);
        $alumno = Alumno::find($request->alumno_id);

        $insert = new AlumnoGrado();
        $insert->anio = $request->anio;
        $insert->grado_seccion_id = $request->grado_seccion_id;
        $insert->alumno_id = $request->alumno_id;
        $insert->save();
        return response()->json(['Registro nuevo' => $insert, 'Mensaje' => 'Felicidades insertaste']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\escuela\sistema\AlumnoGrado  $alumnoGrado
     * @return \Illuminate\Http\Response
     */
    public function show(AlumnoGrado $alumnoGrado)
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
        $grado_seccion = GradoSeccion::find($request->grado_seccion_id);
        $alumno = Alumno::find($request->alumno_id);

        $alumnoGrado->anio = $request->anio;
        $alumnoGrado->grado_seccion_id = $request->grado_seccion_id;
        $alumnoGrado->alumno_id = $request->alumno_id;
        $alumnoGrado->save();
        return response()->json(['Registro editado' => $alumnoGrado, 'Mensaje' => 'Felicidades editate']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\escuela\sistema\AlumnoGrado  $alumnoGrado
     * @return \Illuminate\Http\Response
     */
    public function destroy(AlumnoGrado $alumnoGrado)
    {
        $alumnoGrado->delete();
        return response()->json(['Registro eliminado' => $alumnoGrado, 'Mensaje' => 'Felicidades eliminaste']);  
      }
}
