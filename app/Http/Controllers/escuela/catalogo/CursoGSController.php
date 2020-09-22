<?php

namespace App\Http\Controllers\escuela\catalogo;

use App\Http\Controllers\Controller;
use App\Models\escuela\catalogo\Curso;
use App\Models\escuela\catalogo\CursoGS;
use App\Models\escuela\catalogo\GradoSeccion;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class CursoGSController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('administrador');
        //$this->middleware('director');
        $this->middleware('secretaria');
        $this->middleware('catedratico');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            if ($request->has('buscar'))
                $values = CursoGS::search($request->buscar)->orderBy('created_at', 'DESC')->paginate(10);
            else
                $values = CursoGS::orderBy('created_at', 'DESC')->paginate(10);

            return view('escuela.catalogo.curso_grado_seccion.index ', ['values' => $values]);
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
        try {
            return view('escuela.catalogo.curso_grado_seccion.create');
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('cursoGS.index')->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('cursoGS.index')->with('danger', $th->getMessage());
        }
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
        try {

        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('cursoGS.index')->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('cursoGS.index')->with('danger', $th->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\escuela\catalogo\CursoGS  $cursoGS
     * @return \Illuminate\Http\Response
     */
    public function edit(CursoGS $cursoGS)
    {
        try {
            return view('escuela.catalogo.curso_grado_seccion.edit', ['values' => $cursoGS]);
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('cursoGS.index')->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('cursoGS.index')->with('danger', $th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\escuela\catalogo\CursoGS  $cursoG
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CursoGS $cursoGS)
    {
        $grado_seccion = GradoSeccion::find($request->grado_seccion_id);
        $curso = Curso::find($request->curso_id);

        $cursoGS->nombre_completo = "{$grado_seccion->nombre_completo} {$curso->nombre}";
        $cursoGS->grado_seccion_id = $request->grado_seccion_id;
        $cursoGS->curso_id = $request->curso_id;
        $cursoGS->save();

        return response()->json(['Registro editado' => $cursoGS, 'Mensaje' => 'Felicidades editaste']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\escuela\catalogo\CursoGS  $cursoGS
     * @return \Illuminate\Http\Response
     */
    public function destroy(CursoGS $cursoGS)
    {
        try {
            $cursoGS->delete();

            return redirect()->route('cursoGS.index')->with('info', '¡El registro fue eliminado exitosamente!');
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                dd($th);
                //return redirect()->route('cur$cursoGS.index')->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('cursoGS.index')->with('danger', $th->getMessage());
        }
    }
}
