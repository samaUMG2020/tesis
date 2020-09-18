<?php

namespace App\Http\Controllers\escuela\catalogo;

use App\Http\Controllers\Controller;
use App\Models\escuela\catalogo\Departamento;
use Illuminate\Http\Request;

class DepartamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $values =Departamento::get(); 
        return response()->json(['Consulta realizada', $values, 'Mensaje' => 'Consultaste']);
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
       $dato = Departamento::create($request->all());

        return response()->json([ 'Registro nuevo'=> $dato, 'Mensaje' =>'Felicidades insertastes']);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\escuela\catalogo\Departamento  $departamento
     * @return \Illuminate\Http\Response
     */
    public function show(Departamento $departamento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\escuela\catalogo\Departamento  $departamento
     * @return \Illuminate\Http\Response
     */
    public function edit(Departamento $departamento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\escuela\catalogo\Departamento  $departamento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Departamento $departamento)
    {
        $departamento->nombre = $request->nombre;
        $departamento->save();

        return response()->json(['Registro editado' => $departamento, 'Mensaje' => 'Felicidades editaste']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\escuela\catalogo\Departamento  $departamento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Departamento $departamento)
    {
        $departamento->delete();
        return response()->json(['Registro eliminado' => $departamento, 'Mensaje' => 'Felicidades eliminaste']);
    }
}
