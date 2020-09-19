<?php

namespace App\Http\Controllers\escuela\sistema;

use App\Http\Controllers\Controller;
use App\Models\escuela\catalogo\Curso;
use App\Models\escuela\catalogo\CursoGS;
use App\Models\escuela\sistema\Catedratico;
use App\Models\escuela\sistema\CatedraticoCurso;
use Illuminate\Http\Request;

class CatedraticoCursoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $values = CatedraticoCurso::with('curso_g_s.curso','catedratico')->get();

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
        $cursoGS = CursoGS::find($request->curso_g_s_id) ;
        $cursoGS = Curso::find($request->curso_id);
        $catedratico = Catedratico::find($request->catedratico_id);

        $insert =new CatedraticoCurso();
       // $insert->nombre_completo = "{$cursoGS->nombre_completo}{$catedratico->nombre} {$catedratico->apellido} "; 
        $insert->curso_g_s_id = $request->curso_g_s_id;
        $insert->catedratico_id = $request->catedratico_id;
        $insert->save();

        return response()->json(['Registro ingresado' => $insert, 'Mensaje' => 'Felicidades ingresaste']);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\escuela\sistema\CatedraticoCurso  $catedraticoCurso
     * @return \Illuminate\Http\Response
     */
    public function show(CatedraticoCurso $catedraticoCurso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\escuela\sistema\CatedraticoCurso  $catedraticoCurso
     * @return \Illuminate\Http\Response
     */
    public function edit(CatedraticoCurso $catedraticoCurso)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\escuela\sistema\CatedraticoCurso  $catedraticoCurso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CatedraticoCurso $catedraticoCurso)
    {
        $cursoGS = CursoGS::find($request->cursoGS_id) ;
        $catedratico = Catedratico::find($request->catedratico_id);

        $catedraticoCurso->nombre_completo = "{$cursoGS->nombre_completo}{$catedratico->nombre} {$catedratico->apellido} "; 
        $catedraticoCurso->cursoGSpaerson_id = $request->cursoGS_id;
        $catedraticoCurso->catedratico_id = $request->catedratico_id;
        $catedraticoCurso->save();

        return response()->json(['Registro editado' => $catedraticoCurso, 'Mensaje' => 'Felicidades editaste']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\escuela\sistema\CatedraticoCurso  $catedraticoCurso
     * @return \Illuminate\Http\Response
     */
    public function destroy(CatedraticoCurso $catedraticoCurso)
    {
        $catedraticoCurso->delete();
        return response()->json(['Registro eliminado' => $catedraticoCurso, 'Mensaje' => 'Felicidades eliminaste']);  
    }
}
