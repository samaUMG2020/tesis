<?php

namespace App\Http\Controllers\escuela\catalogo;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\escuela\catalogo\Curso;
use Illuminate\Database\QueryException;
use App\Models\escuela\catalogo\CursoGS;
use App\Models\escuela\catalogo\GradoSeccion;

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
            $cursos = Curso::all();
            $grados_secciones = GradoSeccion::all();

            return view('escuela.catalogo.curso_grado_seccion.create', ['cursos' => $cursos, 'grados_secciones' => $grados_secciones]);
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('cursoG.index')->with('danger', 'Error en la base de datos');
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
        $this->validate(
            $request,
            [
                'curso_id' => 'required|integer|exists:curso,id',
                'grado_seccion_id' => 'required|integer|exists:grado_seccion,id'
            ]

            );

            try {
                $existe = CursoGS::where('curso_id', $request->curso_id)->where('grado_seccion_id', $request->grado_seccion_id)->first();

                if(!is_null($existe)){
                    return redirect()->route('cursoGS.index')->with('warning', '¡El registro que intenta agregar ya existe!');
                }

                $curso = Curso::find($request->curso_id);
                $gradoSeccion = GradoSeccion::find($request->grado_seccion_id);
                
                $insert = new CursoGS();
                $insert->nombre_completo = "{$gradoSeccion->nombre_completo} {$curso->nombre}";
                $insert->curso_id = $request->curso_id;
                $insert->grado_seccion_id = $request->grado_seccion_id;
                $insert->save();
                
                return redirect()->route('cursoGS.index')->with('success', 'El registro fue creado exitosamente!');
             }catch(\Exception $th){
                 if($th instanceof QueryException)
                    return redirect()->route('cursoGS.create')->with('danger', 'Error en la base de datos');
                else 
                return redirect()->route('cursoGS.create')->with('danger', $th->getMessage());
             }
          
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\escuela\catalogo\CursoGS  $cursoGS
     * @return \Illuminate\Http\Response
     */
    public function show($cursoG)
    {
        try {
            $anio_actual = date('Y');
            $datos = DB::table('curso_g_s')
                ->join('curso', 'curso_g_s.curso_id', 'curso.id')
                ->join('grado_seccion', 'curso_g_s.grado_seccion_id', 'grado_seccion.id')
                ->join('seccion', 'grado_seccion.seccion_id', 'seccion.id')
                ->join('grado', 'grado_seccion.grado_id', 'grado.id')
                ->join('carrera', 'grado.carrera_id', 'carrera.id')
                ->select(
                    'curso.id AS id',
                    'curso_g_s.grado_seccion_id AS grado_seccion_id',
                    'curso.nombre AS nombre',
                    DB::RAW('CONCAT(grado.nombre," ",carrera.nombre," - Sección ",seccion.nombre) AS nombre_grado_seccion'),
                    DB::RAW("(SELECT COUNT(*) FROM alumno_grado WHERE alumno_grado.grado_seccion_id = grado_seccion.id AND alumno_grado.anio = {$anio_actual}) AS cantidad")
                )
                ->where('curso_g_s.grado_seccion_id', $cursoG)
                ->get();

            $alumnos = DB::table('alumno_grado')
                ->join('alumno', 'alumno_grado.alumno_id', 'alumno.id')
                ->select('alumno.nombre_completo AS alumno', 'alumno.codigo AS codigo')
                ->where('alumno_grado.grado_seccion_id', $cursoG)
                ->where('alumno_grado.anio', $anio_actual)
                ->get();
                
            return view('escuela.sistema.alumno_grado.index_curso ', ['values' => $datos, 'alumnos' => $alumnos]);
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('alumnoGrado.index')->with('danger', $th->getMessage());
            else
                return redirect()->route('alumnoGrado.index')->with('danger', $th->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\escuela\catalogo\CursoGS  $cursoGS
     * @return \Illuminate\Http\Response
     */
    public function edit(CursoGS $cursoG)
    {
        try {
            $cursos = Curso::all();
            $grados_secciones = GradoSeccion::all();

            return view('escuela.catalogo.curso_grado_seccion.edit', ['values' => $cursoG, 'cursos' => $cursos, 'grados_secciones' => $grados_secciones]);
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
     * @param  \App\Models\escuela\catalogo\CursoGS  $cursoGS
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CursoGS $cursoG)
    {
       
        $this->validate(
            $request,
            [
                'curso_id' => 'required|integer|exists:curso,id',
                'grado_seccion_id' => 'required|integer|exists:grado_seccion,id'
            ]

            );

            try {
                $existe = CursoGS::where('curso_id', $request->curso_id)->where('grado_seccion_id', $request->grado_seccion_id)->first();

                if(!is_null($existe)){
                    return redirect()->route('cursoGS.index')->with('warning', '¡El registro que intenta agregar ya existe!');
                }

                $curso = Curso::find($request->curso_id);
                $gradoSeccion = GradoSeccion::find($request->grado_seccion_id);
                
                $cursoG->nombre_completo = "{$gradoSeccion->nombre_completo} {$curso->nombre}";
                $cursoG->curso_id = $request->curso_id;
                $cursoG->grado_seccion_id = $request->grado_seccion_id;
                $cursoG->save();
                
                return redirect()->route('cursoGS.index')->with('success', 'El registro fue creado exitosamente!');
             }catch(\Exception $th){
                 if($th instanceof QueryException)
                    return redirect()->route('cursoGS.create')->with('danger', 'Error en la base de datos');
                else 
                    return redirect()->route('cursoGS.create')->with('danger', $th->getMessage());
             }
          
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\escuela\catalogo\CursoGS  $cursoGS
     * @return \Illuminate\Http\Response
     */
    public function destroy(CursoGS $cursoG)
    {
        try {
            $cursoG->delete();

            return redirect()->route('cursoGS.index')->with('info', '¡El registro fue eliminado exitosamente!');
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('cursoGS.index')->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('cursoGS.index')->with('danger', $th->getMessage());
        }
    }
}
