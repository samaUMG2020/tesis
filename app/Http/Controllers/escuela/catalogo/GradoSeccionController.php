<?php

namespace App\Http\Controllers\escuela\catalogo;

use App\Http\Controllers\Controller;
use App\Models\escuela\catalogo\Grado;
use App\Models\escuela\catalogo\GradoSeccion;
use App\Models\escuela\catalogo\Seccion;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class GradoSeccionController extends Controller
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
                $values = GradoSeccion::search($request->buscar)->orderBy('created_at', 'DESC')->paginate(10);
            else
                $values = GradoSeccion::orderBy('created_at', 'DESC')->paginate(10);

            return view('escuela.catalogo.grado_seccion.index ', ['values' => $values]);
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
            return view('escuela.catalogo.grado_seccion.create ');
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('gradoSeccion.index')->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('gradoSeccion.index')->with('danger', $th->getMessage());
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
        $grado = Grado::find($request->grado_id);
        $seccion = Seccion::find($request->seccion_id);

        $insert = new GradoSeccion();
        $insert->nombre_completo = "{$grado->nombre_completo} {$seccion->nombre}";
        $insert->seccion_id = $request->seccion_id;
        $insert->grado_id = $request->grado_id;
        $insert->save();

        return response()->json(['Registro nuevo' => $insert, 'Mensaje' => 'Felicidades insertaste']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\escuela\catalogo\GradoSeccion  $gradoSeccion
     * @return \Illuminate\Http\Response
     */
    public function show(GradoSeccion $gradoSeccion)
    {
        try {

        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('gradoSeccion.index')->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('gradoSeccion.index')->with('danger', $th->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\escuela\catalogo\GradoSeccion  $gradoSeccion
     * @return \Illuminate\Http\Response
     */
    public function edit(GradoSeccion $gradoSeccion)
    {
        try {
            return view('escuela.catalogo.grado_seccion.edit', ['values' => $gradoSeccion]);
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('gradoSeccion.index')->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('gradoSeccion.index')->with('danger', $th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\escuela\catalogo\GradoSeccion  $gradoSeccion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GradoSeccion $gradoSeccion)
    {
        $grado = Grado::find($request->grado_id); //100
        $seccion = Seccion::find($request->seccion_id); //1

        $gradoSeccion->nombre_completo = "{$grado->nombre_completo} {$seccion->nombre}";
        $gradoSeccion->seccion_id = $request->seccion_id;
        $gradoSeccion->grado_id = $request->grado_id;
        $gradoSeccion->save();

        return response()->json(['Registro editado' => $gradoSeccion, 'Mensaje' => 'Felicidades editaste']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\escuela\catalogo\GradoSeccion  $gradoSeccion
     * @return \Illuminate\Http\Response
     */
    public function destroy(GradoSeccion $gradoSeccion)
    {
        try {
            $gradoSeccion->delete();

            return redirect()->route('gradoSeccion.index')->with('info', '¡El registro fue eliminado exitosamente!');
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                dd($th);
                //return redirect()->route('tipoFondo.index')->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('gradoSeccion.index')->with('danger', $th->getMessage());
        }
    }
}
