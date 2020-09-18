<?php

namespace App\Http\Controllers\escuela\catalogo;

use App\Http\Controllers\Controller;
use App\Models\escuela\catalogo\TipoFondo;
use Illuminate\Http\Request;

class TipoFondoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $values = TipoFondo::get();
        return response($values);

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
    
        $dato = TipoFondo::create($request->all());

        return response()->json(['Registro nuevo' => $dato, 'Mensaje' => 'Felicidades insertastes']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\escuela\catalogo\TipoFondo  $tipoFondo
     * @return \Illuminate\Http\Response
     */
    public function show(TipoFondo $tipoFondo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\escuela\catalogo\TipoFondo  $tipoFondo
     * @return \Illuminate\Http\Response
     */
    public function edit(TipoFondo $tipoFondo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\escuela\catalogo\TipoFondo  $tipoFondo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TipoFondo $tipoFondo)
    {
        $tipoFondo->nombre = $request->nombre;
        $tipoFondo->save();

        return response()->json(['Registro nuevo' => $tipoFondo, 'Mensaje' => 'Felicidades insertastes']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\escuela\catalogo\TipoFondo  $tipoFondo
     * @return \Illuminate\Http\Response
     */
    public function destroy(TipoFondo $tipoFondo)
    {
        $tipoFondo->delete();
        return response()->json(['Registro eliminado' => $tipoFondo, 'Mensaje' => 'Felicidades elimnaste']);
    }
}
