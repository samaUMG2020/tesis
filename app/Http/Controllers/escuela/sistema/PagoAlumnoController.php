<?php

namespace App\Http\Controllers\escuela\sistema;

use App\Http\Controllers\Controller;
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
        $dato = PagoAlumno::create($request->all());
        
        return response()->json(['Registro nuevo' => $dato, 'Mensaje' => 'Felicidades insertastes']);
         //monto', 'alumno_id', 'grado_id', 'mes_id', 'tipo_pago_alumno_id

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
        $pagoAlumno->nombre = $request->nombre;
        $pagoAlumno->save();

        return response()->json(['Registro editado' => $pagoAlumno, 'Mensaje' => 'Felicidades editates']);
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
        return response()->json(['Registro eliminado' => $pagoAlumno, 'Mensaje' => 'Felicidades elimnaste']);
    }
}
