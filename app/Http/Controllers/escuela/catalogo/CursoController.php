<?php

namespace App\Http\Controllers\escuela\catalogo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\escuela\catalogo\Curso;
use Illuminate\Database\QueryException;

class CursoController extends Controller
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
                $values = Curso::search($request->buscar)->orderBy('created_at', 'DESC')->paginate(10);
            else
                $values = Curso::orderBy('created_at', 'DESC')->paginate(10);

            return view('escuela.catalogo.curso.index', ['values' => $values]);
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
            return view('escuela.catalogo.curso.create');
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('curso.index')->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('curso.index')->with('danger', $th->getMessage());
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
                'nombre' => 'required|max:25|unique:curso,nombre'
            ]
        );

        try {
            Curso::create($request->all());

            return redirect()->route('curso.index')->with('success', '¡El registro fue creado exitosamente!');
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('curso.create')->with('danger', 'Error en la base de datos');
            else 
                return redirect()->route('curso.create')->with('danger', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\escuela\catalogo\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function show(Curso $curso)
    {
        try {

        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('curso.index')->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('curso.index')->with('danger', $th->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\escuela\catalogo\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function edit(Curso $curso)
    {
        try {
            return view('escuela.catalogo.curso.edit', ['values' => $curso]);
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('curso.index')->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('curso.index')->with('danger', $th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\escuela\catalogo\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Curso $curso)
    {
        $this->validate(
            $request,
            [
                'nombre' => 'required|max:25|unique:curso,nombre,'. $curso->id
            ]
        );

        try {
            $curso->nombre = $request->nombre;

            if (!$curso->isDirty())
                return redirect()->route('curso.edit', $curso->id)->with('warning', '¡No existe información para actualizar!');

            $curso->save();

            return redirect()->route('curso.index')->with('success', '¡El registro fue actualizado exitosamente!');
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('curso.edit', $curso->id)->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('curso.edit', $curso->id)->with('danger', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\escuela\catalogo\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function destroy(Curso $curso)
    {
        try {
            $curso->delete();

            return redirect()->route('curso.index')->with('info', '¡El registro fue eliminado exitosamente!');
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('curso.index')->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('curso.index')->with('danger', $th->getMessage());
        }
    }
}
