<?php

namespace App\Http\Controllers\escuela\catalogo;

use App\Http\Controllers\Controller;
use App\Models\escuela\catalogo\TipoFondo;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class TipoFondoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('administrador');
        //$this->middleware('director');
        $this->middleware('secretaria')->only('destroy');
        $this->middleware('catedratico')->only('create', 'store', 'edit', 'update', 'destroy');
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
                $values = TipoFondo::search($request->buscar)->orderBy('created_at', 'DESC')->paginate(10);
            else
                $values = TipoFondo::orderBy('created_at', 'DESC')->paginate(10);

            return view('escuela.catalogo.tipo_fondo.index ', ['values' => $values]);
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
            return view('escuela.catalogo.tipo_fondo.create ');
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('tipo_fondo.index')->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('tipo_fondo.index')->with('danger', $th->getMessage());
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
                'nombre' => 'required|max:25|unique:tipo_fondo,nombre'
            ]
        );
        try {
            TipoFondo::create($request->all());

            return redirect()->route('tipoFondo.index')->with('success', '¡El registro fue creado exitosamente!');
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('tipoFondo.create')->with('danger', 'Error en la base de datos');
            else 
                return redirect()->route('tipoFondo.create')->with('danger', $th->getMessage());
        }
     
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\escuela\catalogo\TipoFondo  $tipoFondo
     * @return \Illuminate\Http\Response
     */
    public function show(TipoFondo $tipoFondo)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\escuela\catalogo\TipoFondo  $tipoFondo
     * @return \Illuminate\Http\Response
     */
    public function edit(TipoFondo $tipoFondo)
    {
        try {
            return view('escuela.catalogo.tipo_fondo.edit', ['values' => $tipoFondo]);
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('tipoFondo.index')->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('tipoFondo.index')->with('danger', $th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\escuela\catalogo\TipoFondo  $tipoFondo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TipoFondo $tipoFondo)
    {
        $this->validate(
            $request,
            [
                'nombre' => 'required|max:25|unique:tipo_fondo,nombre,'. $tipoFondo->id
            ]
        );

        try {
            $tipoFondo->nombre = $request->nombre;

            if (!$tipoFondo->isDirty())
                return redirect()->route('tipoFondo.edit', $tipoFondo->id)->with('warning', '¡No existe información para actualizar!');

            $tipoFondo->save();

            return redirect()->route('tipoFondo.index')->with('success', '¡El registro fue actualizado exitosamente!');
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('tipoFondo.edit', $tipoFondo->id)->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('tipoFondo.edit', $tipoFondo->id)->with('danger', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\escuela\catalogo\TipoFondo  $tipoFondo
     * @return \Illuminate\Http\Response
     */
    public function destroy(TipoFondo $tipoFondo)
    {
        try {
            $tipoFondo->delete();

            return redirect()->route('tipoFondo.index')->with('info', '¡El registro fue eliminado exitosamente!');
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                dd($th);
                //return redirect()->route('tipoFondo.index')->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('tipoFondo.index')->with('danger', $th->getMessage());
        }
    }
}
