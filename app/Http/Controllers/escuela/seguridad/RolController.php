<?php

namespace App\Http\Controllers\escuela\seguridad;

use App\Http\Controllers\Controller;
use App\Models\escuela\seguridad\Rol;
use Illuminate\Http\Request;

class RolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $values = Rol::get();

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
        $dato = Rol::create($request->all());

        return response()->json(['Registro nuevo' => $dato, 'Mensaje' => 'Felicidades insertaste']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\escuela\seguridad\Rol  $rol
     * @return \Illuminate\Http\Response
     */
    public function show(Rol $rol)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\escuela\seguridad\Rol  $rol
     * @return \Illuminate\Http\Response
     */
    public function edit(Rol $rol)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\escuela\seguridad\Rol  $rol
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rol $rol)
    {
        $rol->nombre = $request->nombre;
        $rol->save();

        return response()->json(['Registro editado' => $rol, 'Mensaje' => 'Felicidades editaste']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\escuela\seguridad\Rol  $rol
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rol $rol)
    {
        $rol->delete();
        return response()->json(['Registro eliminado' => $rol, 'Mensaje' => 'Felicidades eliminaste']);
    }
}
