<?php

namespace App\Http\Controllers\escuela\catalogo;

use App\Http\Controllers\Controller;
use App\Models\escuela\catalogo\Carrera;
use App\Models\escuela\catalogo\Grado;
use Illuminate\Http\Request;

class GradoController extends Controller
{
   /* public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('administrador');
        //$this->middleware('director');
        $this->middleware('secretaria');
        $this->middleware('catedratico');
    }*/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('buscar'))
            $values = Grado::search($request->buscar)->orderBy('id', 'DESC')->paginate(10);
        else
            $values = Grado::orderBy('id', 'DESC')->paginate(10);

        return view('escuela.catalogo.grado.index', compact('values'));
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
        $carrera = Carrera::find($request->carrera_id);

        $insert = new Grado();
        $insert->nombre= $request->nombre;
        $insert->nombre_completo = "{$carrera->nombre_completo}";
        $insert->carrera_id = $request->carrera_id;
        $insert->save();

       //$dato = Grado::create($request->all());

        return response()->json(['Registro nuevo' => $insert, 'Mensaje' => 'Felicidades insertaste']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\escuela\catalogo\Grado  $grado
     * @return \Illuminate\Http\Response
     */
    public function show(Grado $grado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\escuela\catalogo\Grado  $grado
     * @return \Illuminate\Http\Response
     */
    public function edit(Grado $grado)
    {
        //
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
        //NO PROBE ESTA FUNCION 
        $carrera = Carrera::find($request->carrera_id);

        $grado->nombre = $request->nombre;
        $grado->nombre_completo= "{$carrera->nombre_completo}";
        $grado->carrera_id = $request->carrera_id;
        $grado->save();

        return response()->json(['Registro editado' => $grado, 'Mensaje' => 'Felicidades editaste']);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\escuela\catalogo\Grado  $grado
     * @return \Illuminate\Http\Response
     */
    public function destroy(Grado $grado)
    {
        $grado->delete();
        return response()->json(['Registro eliminado' => $grado, 'Mensaje' => 'Felicidades eliminaste']);
    }
}

