<?php

namespace App\Http\Controllers\escuela\sistema;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\escuela\catalogo\Mes;
use App\Models\escuela\sistema\Alumno;
use Illuminate\Database\QueryException;
use App\Models\escuela\sistema\PagoAlumno;

class MensualidadController extends Controller
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
            if ($request->has('buscar') && !empty($request->buscar) && !is_null($request->buscar)) {

                $values = DB::table('pago_alumno')
                    ->join('mes', 'pago_alumno.mes_id', 'mes.id')
                    ->join('alumno', 'pago_alumno.alumno_id', 'alumno.id')
                    ->join('tipo_pago_alumno', 'pago_alumno.tipo_pago_alumno_id', 'tipo_pago_alumno.id')
                    ->join('grado_seccion', 'pago_alumno.grado_seccion_id', 'grado_seccion.id')
                    ->join('seccion', 'grado_seccion.seccion_id', 'seccion.id')
                    ->join('grado', 'grado_seccion.grado_id', 'grado.id')
                    ->join('carrera', 'grado.carrera_id', 'carrera.id')
                    ->select(
                        'pago_alumno.id AS id', 
                        'mes.nombre AS mes', 
                        'pago_alumno.monto AS monto', 
                        'pago_alumno.created_at AS created_at',
                        'pago_alumno.anio AS anio',
                        DB::RAW('CONCAT(grado.nombre," ",carrera.nombre," - Sección ",seccion.nombre) AS grado'),
                        'tipo_pago_alumno.nombre AS tipo_pago_alumno',
                        DB::RAW('CONCAT(alumno.codigo,"|",alumno.nombre_completo) AS alumno')
                    )
                    ->where('alumno.codigo', 'LIKE', "%{$request->buscar}%")
                    ->orWhere('pago_alumno.anio', 'LIKE', "%{$request->buscar}%")
                    ->orWhere('alumno.nombre_completo', 'LIKE', "%{$request->buscar}%")
                    ->orderByDesc('pago_alumno.anio')
                    ->orderBy('alumno.nombre_completo')
                    ->orderBy('pago_alumno.mes_id')
                    ->paginate(13);
            }
            else {

                $values = DB::table('pago_alumno')
                    ->join('mes', 'pago_alumno.mes_id', 'mes.id')
                    ->join('alumno', 'pago_alumno.alumno_id', 'alumno.id')
                    ->join('tipo_pago_alumno', 'pago_alumno.tipo_pago_alumno_id', 'tipo_pago_alumno.id')
                    ->join('grado_seccion', 'pago_alumno.grado_seccion_id', 'grado_seccion.id')
                    ->join('seccion', 'grado_seccion.seccion_id', 'seccion.id')
                    ->join('grado', 'grado_seccion.grado_id', 'grado.id')
                    ->join('carrera', 'grado.carrera_id', 'carrera.id')
                    ->select(
                        'pago_alumno.id AS id',
                        'mes.nombre AS mes',
                        'pago_alumno.monto AS monto',
                        'pago_alumno.created_at AS created_at',
                        'pago_alumno.anio AS anio',
                        DB::RAW('CONCAT(grado.nombre," ",carrera.nombre," - Sección ",seccion.nombre) AS grado'),
                        'tipo_pago_alumno.nombre AS tipo_pago_alumno',
                        DB::RAW('CONCAT(alumno.codigo,"|",alumno.nombre_completo) AS alumno')
                    )
                    ->orderByDesc('pago_alumno.anio')
                    ->orderBy('alumno.nombre_completo')
                    ->orderBy('pago_alumno.mes_id')
                    ->paginate(13);
            }

            return view('escuela.sistema.mensualidad.index ', ['values' => $values]);
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
                'monto' => 'required|numeric|between:25,500',
                'mes_id' => 'required|integer|exists:mes,id',
                'inscripcion_id' => 'required|integer|exists:pago_alumno,id'
            ]
        );

        try {

            DB::beginTransaction();

            $inscripcion = PagoAlumno::find($request->inscripcion_id);

            $pago = new PagoAlumno();
            $pago->monto = $request->monto;
            $pago->alumno_id = $inscripcion->alumno_id;
            $pago->grado_seccion_id = $inscripcion->grado_seccion_id;
            $pago->mes_id = $request->mes_id;
            $pago->tipo_pago_alumno_id = 2;
            $pago->anio = $inscripcion->anio;
            $pago->padre_id = $inscripcion->id;
            $pago->save();

            $mes = Mes::find($pago->mes_id);
            $alumno = Alumno::find($pago->alumno_id);

            DB::commit();

            return redirect()->route('inscripcion.show', $inscripcion->id)->with('success', "¡El pago del mes {$mes->nombre} al alumno {$alumno->nombre_completo} fue agregado!");
        } catch (\Exception $th) {
            DB::rollback();
            if ($th instanceof QueryException)
                return redirect()->route('mensualidad.create')->with('danger', $th->getMessage());
            else
                return redirect()->route('mensualidad.create')->with('danger', $th->getMessage());
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
