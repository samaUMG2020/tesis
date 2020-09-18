<?php

namespace App\Http\Controllers\escuela\sistema;

use App\Http\Controllers\Controller;
use App\Models\escuela\catalogo\TipoFondo;
use App\Models\escuela\sistema\Fondo;
use Illuminate\Http\Request;

class FondoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $values = Fondo::with('tipo_fondo')->get();

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
        $tipoFondo = TipoFondo::find($request->tipoFondo_id) ; 

        $insert =new Fondo();
        $insert->nombre = "{$tipoFondo->nombre} "; 
        $insert->cantidad = $request->cantidad;
        $insert->anio = $request->anio;
        $insert->tipoFondo = $request->tipoFondo_id;
       
        $insert->save();

        return response()->json(['Registro editado' => $insert, 'Mensaje' => 'Felicidades insertaste']);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\escuela\sistema\Fondo  $fondo
     * @return \Illuminate\Http\Response
     */
    public function show(Fondo $fondo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\escuela\sistema\Fondo  $fondo
     * @return \Illuminate\Http\Response
     */
    public function edit(Fondo $fondo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\escuela\sistema\Fondo  $fondo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fondo $fondo)
    {
        $tipoFondo = TipoFondo::find($request->tipoFondo_id) ; 

        $tipoFondo->nombre = "{$tipoFondo->nombre} "; 
        $tipoFondo->tipoFondo = $request->tipoFondo_id;
        $tipoFondo->save();

        return response()->json(['Registro editado' => $tipoFondo, 'Mensaje' => 'Felicidades editates']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\escuela\sistema\Fondo  $fondo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fondo $fondo)
    {
        $fondo->delete();
        return response()->json(['Registro eliminado' => $fondo, 'Mensaje' => 'Felicidades elimnaste']);
    }
}
