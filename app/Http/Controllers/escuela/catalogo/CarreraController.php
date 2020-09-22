<?php

namespace App\Http\Controllers\escuela\catalogo;

use App\Http\Controllers\Controller;
use App\Models\escuela\catalogo\Carrera;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class CarreraController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('administrador');
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
                $values = Carrera::search($request->buscar)->orderBy('created_at', 'DESC')->paginate(10);
            else
                $values = Carrera::orderBy('created_at', 'DESC')->paginate(10);

            return view('escuela.catalogo.carrera.index ', ['values' => $values]);
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
            return view('escuela.catalogo.carrera.create ');
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('carrera.index')->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('carrera.index')->with('danger', $th->getMessage());
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
                'nombre' => 'required|max:30|unique:carrera,nombre'
            ]
        );
        try {
            Carrera::create($request->all());

            return redirect()->route('carrera.index')->with('success', '¡El registro fue creado exitosamente!');
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('carrera.create')->with('danger', 'Error en la base de datos');
            else 
                return redirect()->route('carrera.create')->with('danger', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\escuela\catalogo\Carrera  $carrera
     * @return \Illuminate\Http\Response
     */
    public function show(Carrera $carrera)
    {
        try {

        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('carrera.index')->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('carrera.index')->with('danger', $th->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\escuela\catalogo\Carrera  $carrera
     * @return \Illuminate\Http\Response
     */
    public function edit(Carrera $carrera)
    {
        try {
            return view('escuela.catalogo.carrera.edit', ['values' => $carrera]);
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('carrera.index')->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('carrera.index')->with('danger', $th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\escuela\catalogo\Carrera  $carrera
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Carrera $carrera)
    {
        $this->validate(
            $request,
            [
                'nombre' => 'required|max:30|unique:carrera,nombre,'. $carrera->id
            ]
        );

        try {
            $carrera->nombre = $request->nombre;

            if (!$carrera->isDirty())
                return redirect()->route('carrera.edit', $carrera->id)->with('warning', '¡No existe información para actualizar!');

            $carrera->save();

            return redirect()->route('carrera.index')->with('success', '¡El registro fue actualizado exitosamente!');
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('carrera.edit', $carrera->id)->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('carrera.edit', $carrera->id)->with('danger', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\escuela\catalogo\Carrera  $carrera
     * @return \Illuminate\Http\Response
     */
    public function destroy(Carrera $carrera)
    {
        try {
            $carrera->delete();

            return redirect()->route('carrera.index')->with('info', '¡El registro fue eliminado exitosamente!');
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                dd($th);
                //return redirect()->route('carrera.index')->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('carrera.index')->with('danger', $th->getMessage());
        }
    }
}
