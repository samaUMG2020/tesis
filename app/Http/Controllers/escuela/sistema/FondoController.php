<?php

namespace App\Http\Controllers\escuela\sistema;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\escuela\sistema\Fondo;
use Illuminate\Database\QueryException;
use App\Models\escuela\catalogo\TipoFondo;

class FondoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $tipo_fondos = TipoFondo::all();

            if ($request->has('buscar'))
                $values = Fondo::search($request->buscar)->orderBy('anio', 'DESC')->paginate(10);
            else
                $values = Fondo::orderBy('created_at', 'DESC')->paginate(10);

            return view('escuela.sistema.fondo.index ', ['values' => $values, 'tipo_fondos' => $tipo_fondos]);
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('home')->with('danger', $th->getMessage());
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
                'tipo_fondo_id' => 'required|integer|exists:tipo_fondo,id',
                'fondo' => 'required|starts_with:actual,siguiente'
            ]
        );

        try {

            DB::beginTransaction();

            $fondo = new Fondo();
            $fondo->tipo_fondo_id = $request->tipo_fondo_id;
            $fondo->cantidad = $request->cantidad;

            if($request->fondo == 'actual') {
                $fondo->anio = date('Y');
            } else if($request->fondo == 'siguiente'){
                $fondo->anio = date("Y", strtotime(date('Y-m-d') . "+ 1 year"));
            }

            $fondo->save();

            DB::commit();

            return redirect()->route('fondo.index')->with('success', '¡El registro fue creado exitosamente!');
        } catch (\Exception $th) {
            DB::rollback();
            if ($th instanceof QueryException)
                return redirect()->route('fondo.index')->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('fondo.index')->with('danger', 'Error en el controlador');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\escuela\sistema\Fondo  $fondo
     * @return \Illuminate\Http\Response
     */
    public function show(Fondo $fondo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\escuela\sistema\Fondo  $fondo
     * @return \Illuminate\Http\Response
     */
    public function edit(Fondo $fondo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\escuela\sistema\Fondo  $fondo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fondo $fondo)
    { 
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\escuela\sistema\Fondo  $fondo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fondo $fondo)
    {
        try {
            $fondo->delete();

            return redirect()->route('fondo.index')->with('info', '¡El registro fue eliminado exitosamente!');
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('fondo.index')->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('fondo.index')->with('danger', $th->getMessage());
        }
    }
}
