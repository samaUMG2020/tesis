<?php

namespace App\Http\Controllers\escuela\sistema;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\escuela\catalogo\Mes;
use App\Models\escuela\sistema\AlumnoGrado;
use Illuminate\Database\QueryException;
use App\Models\escuela\sistema\PagoAlumno;

class InscripcionController extends Controller
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
            $buscar = '';

            if($request->has('buscar') && !empty($request->buscar) && !is_null($request->buscar))
            {
                $values = DB::table('pago_alumno')
                ->join('alumno', 'pago_alumno.alumno_id', 'alumno.id')
                    ->join('tipo_pago_alumno', 'pago_alumno.tipo_pago_alumno_id', 'tipo_pago_alumno.id')
                    ->join('grado_seccion', 'pago_alumno.grado_seccion_id', 'grado_seccion.id')
                    ->join('seccion', 'grado_seccion.seccion_id', 'seccion.id')
                    ->join('grado', 'grado_seccion.grado_id', 'grado.id')
                    ->join('carrera', 'grado.carrera_id', 'carrera.id')
                    ->select(
                        'pago_alumno.id AS id',
                        'pago_alumno.anio AS anio',
                        'pago_alumno.monto AS monto',
                        DB::RAW('CONCAT(grado.nombre," ",carrera.nombre," - Sección ",seccion.nombre) AS grado'),
                        'tipo_pago_alumno.nombre AS tipo_pago_alumno',
                        DB::RAW('CONCAT(alumno.codigo,"|",alumno.nombre_completo) AS alumno')
                    )
                    ->where('alumno.codigo', 'LIKE', "%{$request->buscar}%")
                    ->orWhere('alumno.nombre_completo', 'LIKE', "%{$request->buscar}%")
                    ->orderByDesc('pago_alumno.anio')
                    ->paginate(20);
                
                $buscar = $request->buscar;
            } else {
                $values = DB::table('pago_alumno')
                    ->join('alumno', 'pago_alumno.alumno_id', 'alumno.id')
                    ->join('tipo_pago_alumno', 'pago_alumno.tipo_pago_alumno_id', 'tipo_pago_alumno.id')
                    ->join('grado_seccion', 'pago_alumno.grado_seccion_id', 'grado_seccion.id')
                    ->join('seccion', 'grado_seccion.seccion_id', 'seccion.id')
                    ->join('grado', 'grado_seccion.grado_id', 'grado.id')
                    ->join('carrera', 'grado.carrera_id', 'carrera.id')
                    ->select(
                        'pago_alumno.id AS id',
                        'pago_alumno.anio AS anio',
                        'pago_alumno.monto AS monto',
                        DB::RAW('CONCAT(grado.nombre," ",carrera.nombre," - Sección ",seccion.nombre) AS grado'),
                        'tipo_pago_alumno.nombre AS tipo_pago_alumno',
                        DB::RAW('CONCAT(alumno.codigo,"|",alumno.nombre_completo) AS alumno')
                    )
                    ->orderByDesc('pago_alumno.anio')
                    ->paginate(20);
            }

            return view('escuela.sistema.inscripcion.index ', ['values' => $values, 'buscar' => $buscar]);
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('home')->with('danger', $th->getMessage());
            else
                return redirect()->route('home')->with('danger', $th->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.s
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $alumnos = DB::table('alumno')
                ->select('alumno.id AS id', 'alumno.nombre_completo AS nombre_completo')
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('pago_alumno')
                        ->whereBetween('pago_alumno.anio', [date('Y'), date("Y", strtotime(date('Y-m-d') . "+ 1 year"))])
                        ->whereRaw('pago_alumno.alumno_id = alumno.id');
                })
                ->where('activo', true)
                ->where('graduado', false)
                ->get();
        
            $grados_secciones = DB::table('grado_seccion')
            ->join('seccion', 'grado_seccion.seccion_id', 'seccion.id')
            ->join('grado', 'grado_seccion.grado_id', 'grado.id')
            ->join('carrera', 'grado.carrera_id', 'carrera.id')
            ->select(
                'grado_seccion.id AS id',
                DB::RAW('CONCAT(grado.nombre," ",carrera.nombre," - Sección ",seccion.nombre) AS nombre')            
            )
            ->get();
            $monto = 200;
            $anio = PagoAlumno::Actual;

            return view('escuela.sistema.inscripcion.create', compact('alumnos', 'grados_secciones', 'monto', 'anio'));
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('inscripcion.index')->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('inscripcion.index')->with('danger', $th->getMessage());
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
                'monto' => 'required|numeric|between:25,500',
                'alumno_id' => 'required|integer|exists:alumno,id',
                'grado_seccion_id' => 'required|integer|exists:grado_seccion,id',
                'anio' => 'starts_with:'.PagoAlumno::Actual.','.PagoAlumno::Proximo
            ]
        );

        try {

            DB::beginTransaction();

            $pago = new PagoAlumno();
            $pago->monto = $request->monto;
            $pago->alumno_id = $request->alumno_id;
            $pago->grado_seccion_id = $request->grado_seccion_id;
            $pago->mes_id = Mes::NA;
            $pago->tipo_pago_alumno_id = 1;
            $pago->anio = $request->anio == PagoAlumno::Actual ? date('Y') : date("Y",strtotime(date('Y-m-d'). "+ 1 year"));
            $pago->save();

            $alumno_grado = new AlumnoGrado();
            $alumno_grado->anio = $pago->anio;
            $alumno_grado->grado_seccion_id = $pago->grado_seccion_id;
            $alumno_grado->alumno_id = $pago->alumno_id;
            $alumno_grado->save();

            DB::commit();

            return redirect()->route('inscripcion.index')->with('success', '¡El registro fue creado exitosamente!');
        } catch (\Exception $th) {
            DB::rollback();
            if ($th instanceof QueryException)
                return redirect()->route('inscripcion.create')->with('danger', $th->getMessage());
            else
                return redirect()->route('inscripcion.create')->with('danger', $th->getMessage());
        }     
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\escuela\sistema\PagoAlumno  $pagoAlumno
     * @return \Illuminate\Http\Response
     */
    public function show(PagoAlumno $pagoAlumno)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\escuela\sistema\PagoAlumno  $pagoAlumno
     * @return \Illuminate\Http\Response
     */
    public function edit(PagoAlumno $pagoAlumno)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\escuela\sistema\PagoAlumno  $pagoAlumno
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PagoAlumno $pagoAlumno)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\escuela\sistema\PagoAlumno  $pagoAlumno
     * @return \Illuminate\Http\Response
     */
    public function destroy(PagoAlumno $pagoAlumno)
    {
        //
    }
}
