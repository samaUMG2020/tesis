<?php

namespace App\Http\Controllers\escuela\sistema;

use App\Http\Controllers\Controller;
use App\Models\escuela\catalogo\Municipio;
use App\Models\escuela\sistema\Persona;
use Illuminate\Http\Request;

class PersonaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $values = Persona::with('municipio')->get();

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
       $municipio = Municipio::find($request->municipio_id);

        $insert = new Persona();
    
        $insert ->nombre= $request->nombre;
        $insert ->apellido= $request->apellido;
        $insert ->email= $request->email;
        $insert ->fecha_nacimiento= $request->fecha_nacimiento;
        $insert ->domicilio= $request->domicilio;
        $insert ->telefono= $request->telefono;
        $insert ->municipio_id= $request->municipio_id;
        $insert->save();


        return response()->json(['Registro nuevo' => $insert, 'Mensaje' => 'Felicidades insertaste']);

/*$dato = Persona::create($request->all());

return response()->json(['Registro nuevo' => $dato, 'Mensaje' => 'Felicidades registraste']);
*/
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\escuela\sistema\Persona  $persona
     * @return \Illuminate\Http\Response
     */
    public function show(Persona $persona)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\escuela\sistema\Persona  $persona
     * @return \Illuminate\Http\Response
     */
    public function edit(Persona $persona)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\escuela\sistema\Persona  $persona
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Persona $persona)
    {
        $municipio = Municipio::find($request->municipio_id);

        $persona ->nombre= $request->nombre;
        $persona ->apellido= $request->apellido;
        $persona ->email= $request->email;
        $persona ->fecha_nacimiento= $request->fecha_nacimiento;
        $persona ->domicilio= $request->domicilio;
        $persona ->telefono= $request->telefono;
        $persona ->municipio_id= $request->municipio_id;
        $persona->save();
       

        return response()->json(['Registro nuevo' => $persona, 'Mensaje' => 'Felicidades editaste']);

        //return response()->json(['Registro editado' => $persona, 'Mensaje' => 'Felicidades editaste']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\escuela\sistema\Persona  $persona
     * @return \Illuminate\Http\Response
     */
    public function destroy(Persona $persona)
    {
        $persona->delete();
        return response()->json(['Registro eliminado' => $persona, 'Mensaje' => 'Felicidades eliminaste']);
    }
}
