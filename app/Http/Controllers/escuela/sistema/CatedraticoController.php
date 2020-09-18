<?php

namespace App\Http\Controllers\escuela\sistema;

use App\Http\Controllers\Controller;
use App\Models\escuela\sistema\Catedratico;
use App\Models\escuela\sistema\Persona;
use Faker\Provider\ar_JO\Person;
use Illuminate\Http\Request;

class CatedraticoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $values = Catedratico::with('persona.municipio')->get();

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
        $persona = Persona::find($request->persona_id) ; 

        $insert =new Catedratico();
        $insert->codigo = $request->codigo;
        $insert->nombre_completo = "{$persona->nombre}{$persona->apellido} "; 
        $insert->persona_id = $request->persona_id;
        $insert->save();

        return response()->json(['Registro editado' => $insert, 'Mensaje' => 'Felicidades editates']);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\escuela\sistema\Catedratico  $catedratico
     * @return \Illuminate\Http\Response
     */
    public function show(Catedratico $catedratico)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\escuela\sistema\Catedratico  $catedratico
     * @return \Illuminate\Http\Response
     */
    public function edit(Catedratico $catedratico)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\escuela\sistema\Catedratico  $catedratico
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Catedratico $catedratico)
    {
        $persona = Persona::find($request->persona_id) ; 

        $catedratico->codigo = $request->codigo;
        $catedratico->nombre_completo = "{$persona->nombre}{$persona->apellido} "; 
        $catedratico->persona_id = $request->persona_id;
        $catedratico->save();

        return response()->json(['Registro ingresado' => $catedratico, 'Mensaje' => 'Felicidades ingresaste']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\escuela\sistema\Catedratico  $catedratico
     * @return \Illuminate\Http\Response
     */
    public function destroy(Catedratico $catedratico)
    {
        $catedratico->delete();
        return response()->json(['Registro eliminado' => $catedratico, 'Mensaje' => 'Felicidades elimnaste']);  
    }
}
