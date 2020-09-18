<?php

namespace App\Http\Controllers\escuela\sistema;

use App\Http\Controllers\Controller;
use App\Models\escuela\sistema\Promedio;
use Illuminate\Http\Request;

class PromedioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $values = Promedio::with('curso')->get();

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
        $dato = Promedio::create($request->all());

        return response()->json(['Registro nuevo' => $dato, 'Mensaje' => 'Felicidades insertastes']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\escuela\sistema\Promedio  $promedio
     * @return \Illuminate\Http\Response
     */
    public function show(Promedio $promedio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\escuela\sistema\Promedio  $promedio
     * @return \Illuminate\Http\Response
     */
    public function edit(Promedio $promedio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\escuela\sistema\Promedio  $promedio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Promedio $promedio)
    {
        $promedio->nombre = $request->nombre;
        $promedio->save();

        return response()->json(['Registro editado' => $promedio, 'Mensaje' => 'Felicidades editates']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\escuela\sistema\Promedio  $promedio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Promedio $promedio)
    {
        $promedio->delete();
        return response()->json(['Registro eliminado' => $promedio, 'Mensaje' => 'Felicidades elimnaste']);
    }
}
