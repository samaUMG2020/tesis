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
        // 'nombre_completo', 'email', 'password', 'persona_id',  'rol_id', 'activo'
        $persona = Persona::find($request->grado_seccion_id);
        $rol = Rol::find($request->curso_id);

        $insert = new Usuario();
        $insert->nombre_completo = $request->nombre_completo;
        $insert->email = $request->email;
        $insert->password = $request->password;
        $insert->persona_id = $request->persona_id;
        $insert->rol_id = $request->rol_id;
        $insert->activo = $request->activo;
        $insert->save();

        return response()->json(['Registro nuevo' => $insert, 'Mensaje' => 'Felicidades insertaste']);
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
        $persona = Persona::find($request->grado_seccion_id);
        $rol = Rol::find($request->curso_id);

       
        $usuario->nombre_completo = $request->nombre_completo;
        $usuario->email = $request->email;
        $usuario->password = $request->password;
        $usuario->persona_id = $request->persona_id;
        $usuario->rol_id = $request->rol_id;
        $usuario->activo = $request->activo;
        $usuario->save();

        return response()->json(['Registro nuevo' => $usuario, 'Mensaje' => 'Felicidades actualizaste']);
    
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
        return response()->json(['Registro eliminado' => $usuario, 'Mensaje' => 'Felicidades eliminaste']);
  
    }
}
