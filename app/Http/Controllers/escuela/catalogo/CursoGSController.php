<?php

namespace App\Http\Controllers\escuela\catalogo;

use App\Http\Controllers\Controller;
use App\Models\escuela\catalogo\Curso;
use App\Models\escuela\catalogo\CursoGS;
use App\Models\escuela\catalogo\GradoSeccion;
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
        $values = CursoGS::with('grado_seccion.grado.carrera', 'grado_seccion.seccion','curso')->get();

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
        $gradoSeccion = GradoSeccion::find($request->grado_seccion_id);
        $curso = Curso::find($request->curso_id);

        $insert = new CursoGS();
        $insert->nombre_completo = "{$gradoSeccion->nombre_completo}, {$curso->nombre}";
        $insert->grado_seccion_id = $request->grado_seccion_id;
        $insert->curso_id = $request->curso_id;
        $insert->save();

        return response()->json(['Registro nuevo' => $insert, 'Mensaje' => 'Felicidades insertaste']);
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
     * @param  \App\Models\escuela\catalogo\CursoGS  $cursoG
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CursoGS $cursoG)
    {
        $grado_seccion = GradoSeccion::find($request->grado_seccion_id);
        $curso = Curso::find($request->curso_id);

        $cursoG->nombre_completo = "{$grado_seccion->nombre_completo} {$curso->nombre}";
        $cursoG->grado_seccion_id = $request->grado_seccion_id;
        $cursoG->curso_id = $request->curso_id;
        $cursoG->save();

        return response()->json(['Registro editado' => $cursoG, 'Mensaje' => 'Felicidades editaste']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\escuela\catalogo\CursoGS  $cursoGS
     * @return \Illuminate\Http\Response
     */
    public function destroy(CursoGS $cursoG)
    {
        $cursoG->delete();
        return response()->json(['Registro eliminado' => $cursoG, 'Mensaje' => 'Felicidades eliminaste']);
    }
}
