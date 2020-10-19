<?php

namespace App\Http\Controllers\escuela\sistema;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use App\Models\escuela\catalogo\CursoGS;
use App\Models\escuela\sistema\Catedratico;
use App\Models\escuela\sistema\CatedraticoCurso;

class CatedraticoCursoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $cursos = $this->cursos_disponibles();
            $catedraticos = Catedratico::where('activo', true)->get();
            $pantalla = 'general';

            if ($request->has('buscar'))
                $values = CatedraticoCurso::search($request->buscar)->orderBy('created_at', 'DESC')->paginate(15);
            else
                $values = CatedraticoCurso::orderBy('created_at', 'DESC')->paginate(15);

            return view('escuela.sistema.catedratico_curso.index ', ['values' => $values, 'cursos' => $cursos, 'catedraticos' => $catedraticos, 'pantalla' => $pantalla]);
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('home')->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('home')->with('danger', $th->getMessage());
        }
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
        $this->validate(
            $request,
            [
                'curso_g_s_id' => 'required|integer|exists:curso_g_s,id',
                'catedratico_id' => 'required|integer|exists:catedratico,id',
                'pantalla' => 'required|starts_with:especifico,general'
            ]
        );

        try {

            DB::beginTransaction();

            CatedraticoCurso::where('curso_g_s_id', $request->curso_g_s_id)->update(['activo' => false]);
            $catedratico_curso = CatedraticoCurso::where('curso_g_s_id', $request->curso_g_s_id)->where('catedratico_id', $request->catedratico_id)->first();

            if(is_null($catedratico_curso)) {
                $catedratico_curso = new CatedraticoCurso();
                $catedratico_curso->curso_g_s_id = $request->curso_g_s_id;
                $catedratico_curso->catedratico_id = $request->catedratico_id;
            } 

            $catedratico_curso->activo = true;
            $catedratico_curso->save();

            DB::commit();

            if($request->pantalla == 'especifico') {
                return redirect()->route('catedraticoCurso.show', $catedratico_curso->catedratico_id)->with('success', '¡El registro fue creado exitosamente!');
            } else if($request->pantalla == 'general') {
                return redirect()->route('catedraticoCurso.index')->with('success', '¡El registro fue creado exitosamente!');
            }
            
        } catch (\Exception $th) {
            DB::rollback();
            if ($th instanceof QueryException)
                return redirect()->route('home.index')->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('home.index')->with('danger', 'Error en el controlador');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\escuela\sistema\CatedraticoCurso  $catedraticoCurso
     * @return \Illuminate\Http\Response
     */
    public function show(Catedratico $catedraticoCurso)
    {
        try {
            $cursos = $this->cursos_disponibles();
            $values = CatedraticoCurso::where('catedratico_id', $catedraticoCurso->id)->paginate(10);
            $pantalla = 'especifico';
            return view('escuela.sistema.catedratico_curso.index_especifico ', ['values' => $values, 'cursos' => $cursos, 'catedratico' => $catedraticoCurso, 'pantalla' => $pantalla]);
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('catedratico.index')->with('danger', 'Error ene la base de datos');
            else
                return redirect()->route('catedratico.index')->with('danger', 'Error en el controlador');
        }
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\escuela\sistema\CatedraticoCurso  $catedraticoCurso
     * @return \Illuminate\Http\Response
     */
    public function destroy(CatedraticoCurso $catedraticoCurso)
    {
        try {

            if($catedraticoCurso->activo) {
                $catedraticoCurso->activo = false;
            } else {
                CatedraticoCurso::where('curso_g_s_id', $catedraticoCurso->curso_g_s_id)->update(['activo' => false]);
                $catedraticoCurso->activo = true;
            }
            
            $catedraticoCurso->save();

            return redirect()->route('catedraticoCurso.index')->with('info', '¡La actualización de estado fue exitosamente!');
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('catedraticoCurso.index')->with('warning', 'Error en la base de datos');
            else
                return redirect()->route('catedraticoCurso.index')->with('warning', 'Error en el controlador');
        } 
    }

    private function cursos_disponibles() 
    {
        return DB::table('curso_g_s')
        ->select('curso_g_s.id AS id', 'curso_g_s.nombre_completo AS nombre_completo')
        ->whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('catedratico_curso')
                ->where('catedratico_curso.activo', true)
                ->whereRaw('catedratico_curso.curso_g_s_id = curso_g_s.id');
        })
        ->get();
    }
}
