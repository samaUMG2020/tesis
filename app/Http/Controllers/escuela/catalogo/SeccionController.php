<?php

namespace App\Http\Controllers\escuela\catalogo;

use App\Http\Controllers\Controller;
use App\Models\escuela\catalogo\Seccion;
use Illuminate\Http\Request;

class SeccionController extends Controller
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
        if ($request->has('buscar'))
            $values = Seccion::search($request->buscar)->orderBy('created_at', 'DESC')->paginate(10);
        else
            $values = Seccion::orderBy('created_at', 'DESC')->paginate(10);

        return view('escuela.catalogo.seccion.index', compact('values'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('escuela.catalogo.seccion.create');
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
                'nombre' => 'required|max:1|unique:seccion,nombre',
            ]
        );

        Seccion::create($request->all());
        return redirect()->route('seccion.index')->with('success', '¡Registro creado satisfactoriamente!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\escuela\catalogo\Seccion  $seccion
     * @return \Illuminate\Http\Response
     */
    public function show(Seccion $seccion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\escuela\catalogo\Seccion  $seccion
     * @return \Illuminate\Http\Response
     */
    public function edit(Seccion $seccion)
    {
        return view('escuela.catalogo.seccion.edit', compact('seccion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\escuela\catalogo\Seccion  $seccion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Seccion $seccion)
    {
        $this->validate(
            $request,
            [
                'nombre' => 'required|max:1|unique:seccion,nombre,' . $seccion->id,
            ]
        );

        $seccion->nombre = $request->nombre;

        if (!$seccion->isDirty())
            return redirect()->route('seccion.edit', $seccion->id)->with('warning', '¡No existe información nueva para actualizar!');

        $seccion->save();

        return redirect()->route('seccion.index')->with('success', '¡Registro actualizado satisfactoriamente!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\escuela\catalogo\Seccion  $seccion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seccion $seccion)
    {
        try {
            $seccion->delete();
            return redirect()->route('seccion.index')->with('success', '¡Registro eliminado satisfactoriamente!');
        } catch (\Exception $e) {
            return redirect()->route('seccion.index')->with('warning', '¡Se produjo un error al intentar eliminar el registro!');
        }
    }
}
