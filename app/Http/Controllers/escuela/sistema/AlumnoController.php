<?php

namespace App\Http\Controllers\escuela\sistema;

use App\Http\Controllers\Controller;
use App\Models\escuela\sistema\Alumno;
use App\Models\escuela\sistema\Persona;
use Illuminate\Http\Request;

class AlumnoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $values = Alumno::with('persona.municipio')->get();
        
        return response()->json(['Registro nuevo' => $values, 'Mensaje' => 'Felicidades consultastes']);
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
        $persona = Persona::find($request->persona_id);

        $insert = new Alumno();
        $insert->codigo = $request->codigo;
        $insert->nombre_completo = "{$persona->nombre} {$persona->apellido}";
        $insert->persona_id = $request->persona_id;
        $insert->save();
    
        //$dato = Alumno::create($request->all());
        return response()->json(['Registro nuevo' => $insert, 'Mensaje' => 'Felicidades insertaste']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\escuela\sistema\Alumno  $alumno
     * @return \Illuminate\Http\Response
     */
    public function show(Alumno $alumno)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\escuela\sistema\Alumno  $alumno
     * @return \Illuminate\Http\Response
     */
    public function edit(Alumno $alumno)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\escuela\sistema\Alumno  $alumno
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Alumno $alumno)
    {
        $persona= Persona::find($request->persona_id);

        $alumno->codigo = $request->codigo;
        $alumno->nombre_completo = "{$persona->nombre} {$alumno->apellido}";
        $alumno->persona_id = $request->persona_id;

        return response()->json(['Registro nuevo' => $alumno, 'Mensaje' => 'Felicidades editaste']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\escuela\sistema\Alumno  $alumno
     * @return \Illuminate\Http\Response
     */
    public function destroy(Alumno $alumno)
    {
        $alumno->delete();
        return response()->json(['Registro eliminado' => $alumno, 'Mensaje' => 'Felicidades eliminaste']);
    }
}
