<?php

namespace App\Http\Controllers\escuela\catalogo;

use App\Http\Controllers\Controller;
use App\Models\escuela\catalogo\Grado;
use App\Models\escuela\catalogo\GradoSeccion;
use App\Models\escuela\catalogo\Seccion;
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
        $values = GradoSeccion::get();

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
        $grado = Grado::find($request->grado_id);
        $seccion = Seccion::find($request->seccion_id);

        $insert = new GradoSeccion();
        $insert->nombre_completo = "{$grado->nombre_completo} {$seccion->nombre}";
        $insert->seccion_id = $request->seccion_id;
        $insert->grado_id = $request->grado_id;
        $insert->save();

        return response()->json(['Registro nuevo' => $insert, 'Mensaje' => 'Felicidades insertastes']);
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
        $grado = Grado::find($request->grado_id); //100
        $seccion = Seccion::find($request->seccion_id); //1

        $gradoSeccion->nombre_completo = "{$grado->nombre_completo} {$seccion->nombre}";
        $gradoSeccion->seccion_id = $request->seccion_id;
        $gradoSeccion->grado_id = $request->grado_id;
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
