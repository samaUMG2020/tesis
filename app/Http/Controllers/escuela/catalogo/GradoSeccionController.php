<?php

namespace App\Http\Controllers\escuela\catalogo;

use App\Http\Controllers\Controller;
use App\Models\escuela\catalogo\GradoSeccion;
use Illuminate\Http\Request;

class GradoSeccionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $values = GradoSeccion::all();

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
        $dato = GradoSeccion::create($request->all());

        return response()->json(['Registro nuevo' => $dato, 'Mensaje' => 'Felicidades insertastes']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\escuela\catalogo\GradoSeccion  $gradoSeccion
     * @return \Illuminate\Http\Response
     */
    public function show(GradoSeccion $gradoSeccion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\escuela\catalogo\GradoSeccion  $gradoSeccion
     * @return \Illuminate\Http\Response
     */
    public function edit(GradoSeccion $gradoSeccion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\escuela\catalogo\GradoSeccion  $gradoSeccion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GradoSeccion $gradoSeccion)
    {
        $gradoSeccion->nombre = $request->nombre;
        $gradoSeccion->save();

        return response()->json(['Registro editado' => $gradoSeccion, 'Mensaje' => 'Felicidades editates']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\escuela\catalogo\GradoSeccion  $gradoSeccion
     * @return \Illuminate\Http\Response
     */
    public function destroy(GradoSeccion $gradoSeccion)
    {
        $gradoSeccion->delete();
        return response()->json(['Registro eliminado' => $gradoSeccion, 'Mensaje' => 'Felicidades elimnaste']);
    }
}
