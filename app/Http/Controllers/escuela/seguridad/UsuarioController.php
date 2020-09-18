<?php

namespace App\Http\Controllers\escuela\seguridad;

use App\Http\Controllers\Controller;
use App\Models\escuela\seguridad\Rol;
use App\Models\escuela\seguridad\Usuario;
use App\Models\escuela\sistema\Persona;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $values = Usuario::get();
        return response()->json($values);
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
        $persona = Persona::find($request->grado_seccion_id);
        $rol = Rol::find($request->curso_id);

        $insert = new Usuario();
        $insert->nombre_completo = "{$persona->nombre_completo}, {$rol->nombre}";
        $insert->persona_id = $request->persona_id;
        $insert->rol_id = $request->rol_id;
        $insert->save();

        return response()->json(['Registro nuevo' => $insert, 'Mensaje' => 'Felicidades insertastes']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\escuela\seguridad\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function show(Usuario $usuario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\escuela\seguridad\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function edit(Usuario $usuario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\escuela\seguridad\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Usuario $usuario)
    {
        $persona = Persona::find($request->persona_id);
        $rol = Rol::find($request->rol_id);

        $usuario->nombre_completo = "{$persona->nombre_completo}, {$rol->nombre}";
        $usuario->persona_id = $request->persona_id;
        $usuario->rol_id = $request->rol_id;
        $usuario->save();

        return response()->json(['Registro nuevo' => $usuario, 'Mensaje' => 'Felicidades insertastes']);
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\escuela\seguridad\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Usuario $usuario)
    {
        $usuario->delete();
        return response()->json(['Registro eliminado' => $usuario, 'Mensaje' => 'Felicidades elimnaste']);
  
    }
}
