<?php

namespace App\Http\Controllers\escuela\catalogo;

use App\Http\Controllers\Controller;
use App\Models\escuela\catalogo\TipoFondo;
use App\Models\escuela\catalogo\TipoPagoAlumno;
use Illuminate\Http\Request;

class TipoPagoAlumnoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $values = TipoPagoAlumno::get();

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
        $dato =TipoPagoAlumno::create($request->all());

        return response()->json(['Registro nuevo' => $dato, 'Mensaje' => 'Felicidades insertaste']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\escuela\catalogo\TipoPagoAlumno  $tipoPagoAlumno
     * @return \Illuminate\Http\Response
     */
    public function show(TipoPagoAlumno $tipoPagoAlumno)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\escuela\catalogo\TipoPagoAlumno  $tipoPagoAlumno
     * @return \Illuminate\Http\Response
     */
    public function edit(TipoPagoAlumno $tipoPagoAlumno)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\escuela\catalogo\TipoPagoAlumno  $tipoPagoAlumno
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TipoPagoAlumno $tipoPagoAlumno)
    {
        $tipoPagoAlumno->nombre = $request->nombre;
        $tipoPagoAlumno->save();

        return response()->json(['Registro editado' => $tipoPagoAlumno, 'Mensaje' => 'Felicidades editaste']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\escuela\catalogo\TipoPagoAlumno  $tipoPagoAlumno
     * @return \Illuminate\Http\Response
     */
    public function destroy(TipoPagoAlumno $tipoPagoAlumno)
    {
        $tipoPagoAlumno->delete();

        return response()->json(['Registro eliminado' => $tipoPagoAlumno, 'Mensaje' => 'Felicidades eliminaste']);
    }
}
