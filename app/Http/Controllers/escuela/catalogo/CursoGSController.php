<?php

namespace App\Http\Controllers\escuela\catalogo;

use App\Http\Controllers\Controller;
use App\Models\escuela\catalogo\CursoGS;
use Illuminate\Http\Request;

class CursoGSController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $values = CursoGS::all();

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
        $dato = CursoGS::create($request->all());

        return response()->json(['Registro nuevo' => $dato, 'Mensaje' => 'Felicidades insertastes']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\escuela\catalogo\CursoGS  $cursoGS
     * @return \Illuminate\Http\Response
     */
    public function show(CursoGS $cursoGS)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\escuela\catalogo\CursoGS  $cursoGS
     * @return \Illuminate\Http\Response
     */
    public function edit(CursoGS $cursoGS)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\escuela\catalogo\CursoGS  $cursoGS
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CursoGS $cursoGS)
    {
        $cursoGS->nombre = $request->nombre;
        $cursoGS->save();

        return response()->json(['Registro editado' => $cursoGS, 'Mensaje' => 'Felicidades editates']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\escuela\catalogo\CursoGS  $cursoGS
     * @return \Illuminate\Http\Response
     */
    public function destroy(CursoGS $cursoGS)
    {
        $cursoGS->delete();
        return response()->json(['Registro eliminado' => $cursoGS, 'Mensaje' => 'Felicidades elimnaste']);
    }
}
