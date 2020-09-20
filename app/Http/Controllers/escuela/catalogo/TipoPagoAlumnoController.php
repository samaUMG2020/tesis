<?php

namespace App\Http\Controllers\escuela\catalogo;

use App\Http\Controllers\Controller;
use App\Models\escuela\catalogo\TipoPagoAlumno;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class TipoPagoAlumnoController extends Controller
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
                $values = TipoPagoAlumno::search($request->buscar)->orderBy('created_at', 'DESC')->paginate(10);
            else
                $values = TipoPagoAlumno::orderBy('created_at', 'DESC')->paginate(10);

            return view('escuela.catalogo.tipo_pago_alumno.index ', ['values' => $values]);
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
            return view('escuela.catalogo.tipo_pago_alumno.create ');
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('tipo_pago_alumno.index')->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('tipo_pago_alumno.index')->with('danger', $th->getMessage());
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
                'nombre' => 'required|max:25|unique:tipo_pago_alumno,nombre'
            ]
        );
        try {
            TipoPagoAlumno::create($request->all());

            return redirect()->route('tipoPagoAlumno.index')->with('success', '¡El registro fue creado exitosamente!');
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('tipoPagoAlumno.create')->with('danger', 'Error en la base de datos');
            else 
                return redirect()->route('tipoPagoAlumno.create')->with('danger', $th->getMessage());
        }
     
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\escuela\catalogo\TipoPagoAlumno  $tipoPagoAlumno
     * @return \Illuminate\Http\Response
     */
    public function show(TipoPagoAlumno $tipoPagoAlumno)
    {
        try {

        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('tipoPagoAlumno.index')->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('tipoPagoAlumno.index')->with('danger', $th->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\escuela\catalogo\TipoPagoAlumno  $tipoPagoAlumno
     * @return \Illuminate\Http\Response
     */
    public function edit(TipoPagoAlumno $tipoPagoAlumno)
    {
        try {
            return view('escuela.catalogo.tipo_pago_alumno.edit', ['values' => $tipoPagoAlumno]);
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('tipoPagoAlumno.index')->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('tipoPagoAlumno.index')->with('danger', $th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\escuela\catalogo\TipoPagoAlumno  $tipoPagoAlumno
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TipoPagoAlumno $tipoPagoAlumno)
    {
        $this->validate(
            $request,
            [
                'nombre' => 'required|max:25|unique:tipo_pago_alumno,nombre,'. $tipoPagoAlumno->id
            ]
        );

        try {
            $tipoPagoAlumno->nombre = $request->nombre;

            if (!$tipoPagoAlumno->isDirty())
                return redirect()->route('$tipoPagoAlumno.edit', $tipoPagoAlumno->id)->with('warning', '¡No existe información para actualizar!');

            $tipoPagoAlumno->save();

            return redirect()->route('tipoPagoAlumno.index')->with('success', '¡El registro fue actualizado exitosamente!');
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('tipoPagoAlumno.edit', $tipoPagoAlumno->id)->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('tipoPagoAlumno.edit', $tipoPagoAlumno->id)->with('danger', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\escuela\catalogo\TipoPagoAlumno  $tipoPagoAlumno
     * @return \Illuminate\Http\Response
     */
    public function destroy(TipoPagoAlumno $tipoPagoAlumno)
    {
       
        try {
            $tipoPagoAlumno->delete();

            return redirect()->route('tipoPagoAlumno.index')->with('info', '¡El registro fue eliminado exitosamente!');
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                dd($th);
                //return redirect()->route('tipoPagoAlumno.index')->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('tipoPagoAlumno.index')->with('danger', $th->getMessage());
        }
    }
}
