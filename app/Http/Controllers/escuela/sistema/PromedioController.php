<?php

namespace App\Http\Controllers\escuela\sistema;

use App\Http\Controllers\Controller;
use App\Models\escuela\catalogo\Curso;
use App\Models\escuela\sistema\AlumnoGrado;
use App\Models\escuela\sistema\Promedio;
use Illuminate\Http\Request;

class PromedioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $values = Promedio::with('curso')->get();

        return response()->json($values);
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
        $alumnoGrado = AlumnoGrado::find($request->alumno_grado_id);
        $curso = Curso::find($request->curso_id);

        $insert = new Promedio();
        $insert ->promedio= $request->promedio;
        $insert ->anio= $request->anio;
        $insert ->bimestres= $request->bimestres; //ARREGLARLO PORQUE DICE QUE NO DEBE SER NULO 
        $insert ->alumno_grado_id= $request->alumno_grado_id;
        $insert ->curso_id= $request->curso_id;
        $insert->save();


        return response()->json(['Registro nuevo' => $insert, 'Mensaje' => 'Felicidades insertaste']);
   
        //'promedio', 'anio', 'bimestres', 'alumno_grado_id', 'curso_id'
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\escuela\sistema\Promedio  $promedio
     * @return \Illuminate\Http\Response
     */
    public function show(Promedio $promedio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\escuela\sistema\Promedio  $promedio
     * @return \Illuminate\Http\Response
     */
    public function edit(Promedio $promedio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\escuela\sistema\Promedio  $promedio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Promedio $promedio)
    {
        $alumnoGrado = AlumnoGrado::find($request->alumno_grado_id);
        $curso = Curso::find($request->curso_id);

        $promedio = new Promedio();
        $promedio ->promedio= $request->promedio;
        $promedio ->anio= $request->anio;
        $promedio ->bimestres= $request->bimestres; 
        $promedio ->alumno_grado_id= $request->alumno_grado_id;
        $promedio ->curso_id= $request->curso_id;
        $promedio->save();

        return response()->json(['Registro editado' => $promedio, 'Mensaje' => 'Felicidades editaste']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\escuela\sistema\Promedio  $promedio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Promedio $promedio)
    {
        $promedio->delete();
        return response()->json(['Registro eliminado' => $promedio, 'Mensaje' => 'Felicidades eliminaste']);
    }
}
