<?php

namespace App\Http\Controllers\escuela\sistema;

use App\Http\Controllers\Controller;
use App\Models\escuela\catalogo\Bimestre;
use App\Models\escuela\catalogo\Curso;
use App\Models\escuela\catalogo\GradoSeccion;
use App\Models\escuela\sistema\Alumno;
use App\Models\escuela\sistema\AlumnoGrado;
use App\Models\escuela\sistema\Nota;
use Illuminate\Http\Request;

class NotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $values = Nota::get();
           
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
        $dato = Nota::create($request->all());

        return response()->json(['Registro nuevo' => $dato, 'Mensaje' => 'Felicidades insertastes']);
       
        /*$alumnoGrado = AlumnoGrado::find($request->alumno_grado_id);
        $curso = Curso::find($request->curso_id); 
        $bimestre = Bimestre::find($request->bimestre_id);

        $insert =new Nota();
        $insert->nota = $request->nota;
        $insert->anio =$request->anio; 
        $insert->curso_id = $request->curso_id;
        $insert->bimestre_id = $request->bimestre_id;
        $insert->alumno_grado_id = $request->alumno_grado_id;
        $insert->save();

        return response()->json(['Registro editado' => $insert, 'Mensaje' => 'Felicidades editates']);
*/
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\escuela\sistema\Nota  $nota
     * @return \Illuminate\Http\Response
     */
    public function show(Nota $nota)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\escuela\sistema\Nota  $nota
     * @return \Illuminate\Http\Response
     */
    public function edit(Nota $nota)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\escuela\sistema\Nota  $nota
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Nota $nota)
    {
        $nota->nombre = $request->nombre;
        $nota->save();

        return response()->json(['Registro editado' => $nota, 'Mensaje' => 'Felicidades editates']);
        /*$alumnoGrado = AlumnoGrado::find($request->alumno_grado_id);
        $curso = Curso::find($request->curso_id); 
        $bimestre = Bimestre::find($request->bimestre_id);

       
        $nota->nota = $request->nota;
        $nota->anio =$request->anio; 
        $nota->curso_id = $request->curso_id;
        $nota->bimestre_id = $request->bimestre_id;
        $nota->alumno_grado_id = $request->alumno_grado_id;
        $nota->save();*/

        return response()->json(['Registro editado' => $nota, 'Mensaje' => 'Felicidades editates']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\escuela\sistema\Nota  $nota
     * @return \Illuminate\Http\Response
     */
    public function destroy(Nota $nota)
    {
        $nota->delete();
        return response()->json(['Registro eliminado' => $nota, 'Mensaje' => 'Felicidades elimnaste']);  
    }
}
