<?php

namespace App\Http\Controllers\escuela\catalogo;

use App\Http\Controllers\Controller;
use App\Models\escuela\catalogo\Carrera;
use App\Models\escuela\catalogo\Grado;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class GradoController extends Controller
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
            $values = Grado::search($request->buscar)->orderBy('created_at', 'DESC')->paginate(10);
        else
            $values = Grado::orderBy('created_at', 'DESC')->paginate(10);

        return view('escuela.catalogo.grado.index ', ['values' => $values]);
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
            $carreras = Carrera::all();

            return view('escuela.catalogo.grado.create', ['carreras' => $carreras]);
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('grado.index')->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('grado.index')->with('danger', $th->getMessage());
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
                'nombre' => 'required|max:10',
                'carrera_id' => 'required|integer|exists:carrera,id'
            ]
        );

        try {

            $existe = Grado::where('carrera_id', $request->carrera_id)->where('nombre', $request->nombre)->first();

            if (!is_null($existe)) {
                return redirect()->route('grado.index')->with('warning', '¡El registro que intenta agregar ya existe!');
            }


            $carrera = Carrera::find($request->carrera_id);

            $insert = new Grado();
            $insert->nombre = $request->nombre;
            $insert->nombre_completo = "{$carrera->nombre} - {$insert->nombre}";
            $insert->carrera_id = $request->carrera_id;
            $insert->save();

            return redirect()->route('grado.index')->with('success', '¡El registro fue creado exitosamente!');
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('grado.create')->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('grado.create')->with('danger', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\escuela\catalogo\Grado  $grado
     * @return \Illuminate\Http\Response
     */
    public function show(Grado $grado)
    {
        try {

        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('grado.index')->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('grado.index')->with('danger', $th->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\escuela\catalogo\Grado  $grado
     * @return \Illuminate\Http\Response
     */
    public function edit(Grado $grado)
    {
        try {
            $carreras = Carrera::all();

            return view('escuela.catalogo.grado.edit', ['values' => $grado, 'carreras' => $carreras]);
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('grado.index')->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('grado.index')->with('danger', $th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\escuela\catalogo\Grado  $grado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Grado $grado)
    {
        $this->validate(
            $request,
            [
                'nombre' => 'required|max:10',
                'carrera_id' => 'required|integer|exists:carrera,id'
            ]
        );

        try {

            $existe = Grado::where('carrera_id', $request->carrera_id)->where('nombre', $request->nombre)->first();

            if (!is_null($existe)) {
                return redirect()->route('grado.index')->with('warning', '¡El registro que intenta agregar ya existe!');
            }


            $carrera = Carrera::find($request->carrera_id);

            $grado->nombre = $request->nombre;
            $grado->nombre_completo = "{$carrera->nombre} - {$grado->nombre}";
            $grado->carrera_id = $request->carrera_id;
            $grado->save();

            return redirect()->route('grado.index')->with('success', '¡El registro fue actualizado exitosamente!');
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('grado.create')->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('grado.create')->with('danger', $th->getMessage());
        }
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\escuela\catalogo\Grado  $grado
     * @return \Illuminate\Http\Response
     */
    public function destroy(Grado $grado)
    {
        try {
            $grado->delete();

            return redirect()->route('grado.index')->with('info', '¡El registro fue eliminado exitosamente!');
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('grado.index')->with('warning', 'Error en la base de datos');
            else
                return redirect()->route('grado.index')->with('warning', $th->getMessage());
        }
    }
}

