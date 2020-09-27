<?php

namespace App\Http\Controllers\escuela\sistema;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\escuela\catalogo\Mes;
use App\Models\escuela\sistema\Alumno;
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
                        DB::RAW('CONCAT(alumno.codigo,"|",alumno.nombre_completo) AS alumno'),
                        DB::RAW('(SELECT alumno_grado.activo FROM alumno_grado WHERE alumno_grado.anio = pago_alumno.anio AND alumno_grado.grado_seccion = pago_alumno.grado_seccion AND alumno_grado.alumno_id = pago_alumno.alumno_id) AS activo')
                    )
                    ->where('pago_alumno.mes_id', Mes::NA)
                    ->where('alumno.codigo', 'LIKE', "%{$request->buscar}%")
                    ->orWhere('alumno.nombre_completo', 'LIKE', "%{$request->buscar}%")
                    ->orderByDesc('pago_alumno.anio')
                    ->orderBy('grado.nombre')
                    ->orderBy('seccion.nombre')
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
                        DB::RAW('CONCAT(alumno.codigo,"|",alumno.nombre_completo) AS alumno'),
                        DB::RAW('(SELECT alumno_grado.activo FROM alumno_grado WHERE alumno_grado.anio = pago_alumno.anio AND alumno_grado.grado_seccion_id = pago_alumno.grado_seccion_id AND alumno_grado.alumno_id = pago_alumno.alumno_id) AS activo')
                    )
                    ->where('pago_alumno.mes_id', Mes::NA)
                    ->orderByDesc('pago_alumno.anio')
                    ->orderBy('grado.nombre')
                    ->orderBy('seccion.nombre')
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
                        ->where('pago_alumno.mes_id', Mes::NA)
                        ->where('pago_alumno.anio', date('Y'))
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
            $monto = PagoAlumno::MontoI;
            $anio = PagoAlumno::Actual;

            return view('escuela.sistema.inscripcion.create', compact('alumnos', 'grados_secciones', 'monto', 'anio'));
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('inscripcion.index')->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('inscripcion.index')->with('danger', $th->getMessage());
        }
    }

    public function create_siguiente()
    {
        try {
            $alumnos = DB::table('alumno')
            ->select('alumno.id AS id', 'alumno.nombre_completo AS nombre_completo')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('pago_alumno')
                    ->where('pago_alumno.mes_id', Mes::NA)
                    ->where('pago_alumno.anio', date("Y", strtotime(date('Y-m-d') . "+ 1 year")))
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
            $monto = PagoAlumno::MontoI;
            $anio = PagoAlumno::Proximo;

            return view('escuela.sistema.inscripcion.create_siguiente', compact('alumnos', 'grados_secciones', 'monto', 'anio'));
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
                'grado_seccion_id' => 'required|integer|exists:grado_seccion,id'
            ]
        );

        try {

            DB::beginTransaction();

            AlumnoGrado::where('alumno_id', $request->alumno_id)->update(['activo' => false]);

            $pago = new PagoAlumno();
            $pago->monto = $request->monto;
            $pago->alumno_id = $request->alumno_id;
            $pago->grado_seccion_id = $request->grado_seccion_id;
            $pago->mes_id = Mes::NA;
            $pago->tipo_pago_alumno_id = 1;
            $pago->anio = date('Y');
            $pago->padre_id = 0;
            $pago->save();

            $alumno_grado = new AlumnoGrado();
            $alumno_grado->anio = $pago->anio;
            $alumno_grado->grado_seccion_id = $pago->grado_seccion_id;
            $alumno_grado->alumno_id = $pago->alumno_id;
            $alumno_grado->save();

            $alumno = Alumno::find($alumno_grado->alumno_id);
            $alumno->fin_ciclo = false;
            $alumno->save();

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

    public function store_siguiente(Request $request)
    {
        $this->validate(
            $request,
            [
                'monto' => 'required|numeric|between:25,500',
                'alumno_id' => 'required|integer|exists:alumno,id',
                'grado_seccion_id' => 'required|integer|exists:grado_seccion,id'
            ]
        );

        try {

            DB::beginTransaction();

            AlumnoGrado::where('alumno_id', $request->alumno_id)->update(['activo' => false]);

            $pago = new PagoAlumno();
            $pago->monto = $request->monto;
            $pago->alumno_id = $request->alumno_id;
            $pago->grado_seccion_id = $request->grado_seccion_id;
            $pago->mes_id = Mes::NA;
            $pago->tipo_pago_alumno_id = 1;
            $pago->anio = date("Y", strtotime(date('Y-m-d') . "+ 1 year"));
            $pago->padre_id = 0;
            $pago->save();

            $alumno_grado = new AlumnoGrado();
            $alumno_grado->anio = $pago->anio;
            $alumno_grado->grado_seccion_id = $pago->grado_seccion_id;
            $alumno_grado->alumno_id = $pago->alumno_id;
            $alumno_grado->save();

            $alumno = Alumno::find($alumno_grado->alumno_id);
            $alumno->fin_ciclo = false;
            $alumno->save();

            DB::commit();

            return redirect()->route('inscripcion.index')->with('success', '¡El registro fue creado exitosamente!');
        } catch (\Exception $th) {
            DB::rollback();
            if ($th instanceof QueryException)
                return redirect()->route('inscripcion.create_siguiente')->with('danger', $th->getMessage());
            else
                return redirect()->route('inscripcion.create_siguiente')->with('danger', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\escuela\sistema\PagoAlumno  $pagoAlumno
     * @return \Illuminate\Http\Response
     */
    public function show($pagoAlumno)
    {
        try {

            $inscripcion = PagoAlumno::find($pagoAlumno);
            $mensualidades = DB::table('pago_alumno')
                ->join('mes', 'pago_alumno.mes_id', 'mes.id')
                ->select('pago_alumno.id AS id', 'mes.nombre AS mes', 'pago_alumno.monto AS monto', 'pago_alumno.created_at AS created_at')
                ->where('pago_alumno.padre_id', $inscripcion->id)
                ->get();
            $alumno_grado = AlumnoGrado::where([
                'anio' => $inscripcion->anio,
                'grado_seccion_id' => $inscripcion->grado_seccion_id,
                'alumno_id' => $inscripcion->alumno_id
            ])->first();
            $meses = DB::table('mes')
                ->select('mes.id AS id', 'mes.nombre AS nombre')
                ->whereNotExists(function ($query) use ($inscripcion) {
                    $query->select(DB::raw(1))
                        ->from('pago_alumno')
                        ->where('pago_alumno.padre_id', $inscripcion->id)
                        ->whereRaw('pago_alumno.mes_id = mes.id');
                })
                ->where('id', '!=', Mes::NA)
                ->get();
            $monto = PagoAlumno::MontoM;

            return view('escuela.sistema.mensualidad.index_especifico', compact('inscripcion', 'mensualidades', 'alumno_grado', 'meses', 'monto'));
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('inscripcion.index')->with('danger', $th->getMessage());
            else
                return redirect()->route('inscripcion.index')->with('danger', $th->getMessage());
        }
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
    public function destroy($pagoAlumno)
    {
        try {

            $pagoAlumno = PagoAlumno::find($pagoAlumno);
            $pago_meses = PagoAlumno::where('padre_id', $pagoAlumno->id)->get();

            if(count($pago_meses) > 0) {
                return redirect()->route('inscripcion.index')->with('warning', '¡No puede eliminar la inscripción por que ya existen mensualidades registradas!');
            }
            else {

                DB::beginTransaction();

                AlumnoGrado::where([
                    'anio' => $pagoAlumno->anio,
                    'grado_seccion_id' => $pagoAlumno->grado_seccion_id,
                    'alumno_id' => $pagoAlumno->alumno_id
                ])->delete();

                $alumno = Alumno::find($pagoAlumno->alumno_id);
                $alumno->fin_ciclo = false;
                $alumno->save();

                $pagoAlumno->delete();

                DB::commit();
            }

            return redirect()->route('inscripcion.index')->with('info', '¡El registro fue eliminado exitosamente!');
        } catch (\Exception $th) {
            DB::rollback();
            if ($th instanceof QueryException)
                return redirect()->route('inscripcion.index')->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('inscripcion.index')->with('danger', $th->getMessage());
        }
    }
}
