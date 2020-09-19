<?php

namespace App\Http\Controllers\escuela\sistema;

use App\Http\Controllers\Controller;
use App\Models\escuela\catalogo\Grado;
use App\Models\escuela\catalogo\Mes;
use App\Models\escuela\catalogo\TipoPagoAlumno;
use App\Models\escuela\sistema\Alumno;
use App\Models\escuela\sistema\PagoAlumno;
use Illuminate\Http\Request;

class PagoAlumnoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $values = PagoAlumno::get();

        return response()->json($values);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $alumno = Alumno::find($request->alumno_id);
        $grado = Grado::find($request->grado_id);
        $mes = Mes::find($request->mes_id);
        $tipoPagoAlumno =TipoPagoAlumno::find($request->tipo_pago_alumno_id);

        $insert = new PagoAlumno();
        $insert ->monto = $request->monto;
        $insert ->alumno_id = $request->alumno_id;
        $insert ->grado_id = $request->grado_id;
        $insert ->mes_id = $request->mes_id; //EL MISMO ALUMNO PUEDE PAGAR EL MISMO MES MAS DE UNA VEZ
        $insert ->tipo_pago_alumno_id = $request->tipo_pago_alumno_id;
        $insert->save();
        
        return response()->json(['Registro nuevo' => $insert, 'Mensaje' => 'Felicidades insertaste']);
        

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
        $alumno = Alumno::find($request->alumno_id);
        $grado = Grado::find($request->grado_id);
        $mes = Mes::find($request->mes_id);
        $tipoPagoAlumno =TipoPagoAlumno::find($request->tipo_pago_alumno_id);
    
        $pagoAlumno ->monto = $request->monto;
        $pagoAlumno ->alumno_id = $request->alumno_id;
        $pagoAlumno ->grado_id = $request->grado_id;
        $pagoAlumno ->mes_id = $request->mes_id;
        $pagoAlumno ->tipo_pago_alumno_id = $request->tipo_pago_alumno_id;
        $pagoAlumno->save();
        
        return response()->json(['Registro nuevo' => $pagoAlumno, 'Mensaje' => 'Felicidades editaste']);
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\escuela\sistema\PagoAlumno  $pagoAlumno
     * @return \Illuminate\Http\Response
     */
    public function destroy(PagoAlumno $pagoAlumno)
    {
        $pagoAlumno->delete();
        return response()->json(['Registro eliminado' => $pagoAlumno, 'Mensaje' => 'Felicidades eliminaste']);
    }
}
