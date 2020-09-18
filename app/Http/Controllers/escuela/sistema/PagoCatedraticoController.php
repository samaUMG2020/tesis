<?php

namespace App\Http\Controllers\escuela\sistema;

use App\Http\Controllers\Controller;
use App\Models\escuela\sistema\PagoCatedratico;
use Illuminate\Http\Request;

class PagoCatedraticoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $values = PagoCatedratico::get();

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
        $dato = PagoCatedratico::Create($request->all());
        return response()->json()(['Registro nuevo' => $dato, 'Mensaje' => 'Felicidades insertastes']);
    
        // 'monto', 'anio', 'catedratico_id', 'mes_id'
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\escuela\sistema\PagoCatedratico  $pagoCatedratico
     * @return \Illuminate\Http\Response
     */
    public function show(PagoCatedratico $pagoCatedratico)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\escuela\sistema\PagoCatedratico  $pagoCatedratico
     * @return \Illuminate\Http\Response
     */
    public function edit(PagoCatedratico $pagoCatedratico)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\escuela\sistema\PagoCatedratico  $pagoCatedratico
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PagoCatedratico $pagoCatedratico)
    {
        $pagoCatedratico->nombre = $request->nombre;
        $pagoCatedratico->save();

        return response()->json(['Registro editado' => $pagoCatedratico, 'Mensaje' =>  'Felicidades editaste']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\escuela\sistema\PagoCatedratico  $pagoCatedratico
     * @return \Illuminate\Http\Response
     */
    public function destroy(PagoCatedratico $pagoCatedratico)
    {
        $pagoCatedratico->delete();
        return response()->json(['Registro eliminado' => $pagoCatedratico, 'Mensaje' =>  'Felicidades eliminaste']);

    }
}
