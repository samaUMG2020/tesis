<?php

namespace App\Http\Controllers\escuela\sistema;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\escuela\catalogo\Mes;
use Illuminate\Database\QueryException;
use App\Models\escuela\sistema\PagoCatedratico;

class PagoCatedraticoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $values = Mes::where('id','!=',13)->orderBy('id', 'ASC')->get();
            return view('escuela.sistema.pago_catedratico.index ', ['values' => $values]);
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('home')->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('home')->with('danger', 'Error en el controlador');
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
                'catedratico_id.*' => 'required|integer|exists:catedratico,id',
                'mes_id' => 'required|integer|exists:mes,id',
                'monto.*' => 'required|numeric|between:0,20000'
            ],
            [
                'catedratico_id.*.required' => 'El catedrático a quien se le realizará el pago es obligatorio',
                'catedratico_id.*.integer' => 'El código del catedrático no tiene formato correcto',
                'catedratico_id.*.exists' => 'El código del catedrático no se encuentra registrado en la base de datos',

                'mes_id.required' => 'El mes en que se realizará el pago es obligatorio',
                'mes_id.integer' => 'El mes no tiene formato correcto',
                'mes_id.exists' => 'El mes no se encuentra registrado en la base de datos',

                'monto.*.required' => 'Es necesario el monto del pago a realizar',
                'monto.*.numeric' => 'Solo se aceptan números en los montos de pago',
                'monto.*.between' => 'En el monto de pago solo puede ser :min o menor que :max quetzales'
            ]
        );
        
        try {
            DB::beginTransaction();

            $anio_actual = date('Y');
            $mes = Mes::find($request->mes_id);

            for ($i = 0; $i < count($request->catedratico_id); $i++) {
                $pago_catedratico = PagoCatedratico::where('catedratico_id', $request->catedratico_id[$i])
                    ->where('mes_id', $mes->id)
                    ->where('anio', $anio_actual)
                    ->first();

                if(is_null($pago_catedratico)) {
                    $pago_catedratico = new PagoCatedratico();
                    $pago_catedratico->catedratico_id = $request->catedratico_id[$i];
                    $pago_catedratico->mes_id = $mes->id;
                    $pago_catedratico->anio = $anio_actual;
                }

                $pago_catedratico->monto = $request->monto[$i];
                $pago_catedratico->save();
            }

            DB::commit();

            return redirect()->route('pagoCatedratico.show', $mes->id)->with('success', '¡El registro fue creado exitosamente!');
        } catch (\Exception $th) {
            DB::rollback();
            if ($th instanceof QueryException
            )
            return redirect()->route('pagoCatedratico.show', $request->grado_seccion_id)->with('danger', $th->getMessage());
            else
                return redirect()->route('pagoCatedratico.show', $request->grado_seccion_id)->with('danger', "Error al ingresar");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\escuela\sistema\PagoCatedratico  $pagoCatedratico
     * @return \Illuminate\Http\Response
     */
    public function show(Mes $pagoCatedratico)
    {
        try {
            $anio_actual = date('Y');
            $pagos = DB::table('catedratico')
                ->select(
                        'catedratico.id AS catedratico_id',
                        'catedratico.nombre_completo AS nombre_completo',
                        DB::RAW("(SELECT pago_catedratico.monto FROM pago_catedratico WHERE pago_catedratico.catedratico_id = catedratico.id AND pago_catedratico.mes_id = {$pagoCatedratico->id} AND pago_catedratico.anio = {$anio_actual}) AS monto")
                    )
                ->where('catedratico.activo', true)
                ->get();
            return view('escuela.sistema.pago_catedratico.registrar ', ['pagos' => $pagos, 'mes' => $pagoCatedratico]);
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('pagoCatedratico.index')->with('danger', 'Error ene la base de datos');
            else
                return redirect()->route('pagoCatedratico.index')->with('danger', 'Error en el controlador');
        }
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
        //
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\escuela\sistema\PagoCatedratico  $pagoCatedratico
     * @return \Illuminate\Http\Response
     */

    public function destroy(PagoCatedratico $pagoCatedratico)
    {
        //
    }
}
