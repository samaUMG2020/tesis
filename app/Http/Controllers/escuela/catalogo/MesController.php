<?php

namespace App\Http\Controllers\escuela\catalogo;

use App\Http\Controllers\Controller;
use App\Models\escuela\catalogo\Mes;
use Illuminate\Http\Request;

class MesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $values = Mes::all();

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
        /*$this->validate(
            $request,
            [
                'nombre' => 'required|max:1|unique:mes,nombre',
            ]
        );*/

        $dato = Mes::create($request->all());

        return response()->json(['Registro nuevo' => $dato, 'Mensaje' => 'Felicidades insertaste']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\escuela\catalogo\Mes  $mes
     * @return \Illuminate\Http\Response
     */
    public function show(Mes $me)
    {
        return response()->json(['Registro de la busqueda' => $me, 'Mensaje' => 'Felicidades encontraste un registro']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\escuela\catalogo\Mes  $mes
     * @return \Illuminate\Http\Response
     */
    public function edit(Mes $mes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\escuela\catalogo\Mes  $mes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mes $me)
    {
        $me->nombre = $request->nombre;
        $me->save();

        return response()->json(['Registro editado' => $me, 'Mensaje' => 'Felicidades editaste']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\escuela\catalogo\Mes  $mes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mes $me)
    {
        $me->delete();
        return response()->json(['Registro eliminado' => $me, 'Mensaje' => 'Felicidades eliminaste']);
    }
}
