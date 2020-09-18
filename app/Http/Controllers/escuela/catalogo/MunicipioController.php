<?php

namespace App\Http\Controllers\escuela\catalogo;

use App\Http\Controllers\Controller;
use App\Models\escuela\catalogo\Departamento;
use App\Models\escuela\catalogo\Municipio;
use Illuminate\Http\Request;

class MunicipioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $values = Municipio::with('departamento')->get();

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
        $departamento = Departamento::find($request->departamento_id);

        $insert = new Municipio();
        $insert ->nombre= $request->nombre;
        $insert ->nombre_completo = "{$departamento->nombre_completo}";
        $insert ->departamento_id= $request->departamento_id;
        $insert ->save();

        return response()->json(['Registro nuevo' => $insert, 'Mensaje' => 'Felicidades insertastes']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\escuela\catalogo\Municipio  $municipio
     * @return \Illuminate\Http\Response
     */
    public function show(Municipio $municipio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\escuela\catalogo\Municipio  $municipio
     * @return \Illuminate\Http\Response
     */
    public function edit(Municipio $municipio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\escuela\catalogo\Municipio  $municipio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Municipio $municipio)
    {
        $departamento = Departamento::find($request->departamento_id);

        $municipio ->nombre_completo = "{$departamento->nombre_completo}";
        $municipio ->nombre= $request->nombre;
        $municipio ->departamento_id= $request->departamento_id;
        $municipio ->save();

        return response()->json(['Registro nuevo' => $municipio, 'Mensaje' => 'Felicidades insertastes']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\escuela\catalogo\Municipio  $municipio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Municipio $municipio)
    {
        $municipio->delete();
        return response()->json(['Registro eliminado' => $municipio, 'Mensaje' => 'Felicidades elimnaste']);
    }
}
