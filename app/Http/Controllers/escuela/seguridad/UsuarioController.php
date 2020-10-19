<?php

namespace App\Http\Controllers\escuela\seguridad;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\escuela\seguridad\Rol;
use App\Models\escuela\sistema\Persona;
use Illuminate\Database\QueryException;
use App\Models\escuela\seguridad\Usuario;
use App\Models\escuela\catalogo\Municipio;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            if ($request->has('buscar'))
                $values = Usuario::search($request->buscar)->orderBy('created_at', 'DESC')->paginate(15);
            else
                $values = Usuario::orderBy('created_at', 'DESC')->paginate(15);

            return view('escuela.seguridad.usuario.index ', ['values' => $values]);
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
            $municipios = Municipio::all();
            $roles = Rol::all();

            return view('escuela.seguridad.usuario.create', compact('municipios', 'roles'));
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('usuario.index')->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('usuario.index')->with('danger', $th->getMessage());
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
                'nombre' => 'required|max:40',
                'apellido' => 'required|max:40',
                'email' => 'required|max:50|email|unique:usuario,email',
                'fecha_nacimiento' => 'required|date_format:d-m-Y',
                'domicilio' => 'max:100',
                'telefono' => 'nullable|digits_between:8,8',
                'municipio_id' => 'required|integer|exists:municipio,id',
                'rol_id' => 'required|integer|exists:rol,id',
                'password' => 'required|min:6|max:15'
            ]
        );

        try {

            DB::beginTransaction();

            $persona = new Persona();
            $persona->nombre = $request->nombre;
            $persona->apellido = $request->apellido;
            $persona->email = $request->email;
            $persona->fecha_nacimiento = date('Y-m-d', strtotime($request->fecha_nacimiento));
            $persona->domicilio = $request->domicilio;
            $persona->telefono = $request->telefono;
            $persona->municipio_id = $request->municipio_id;
            $persona->save();

            $usuario = new Usuario();
            $usuario->email = $persona->email;
            $usuario->password = $request->password;
            $usuario->rol_id = $request->rol_id;
            $usuario->nombre_completo = "{$persona->nombre} {$persona->apellido}";
            $usuario->persona_id = $persona->id;
            $usuario->activo = true;
            $usuario->save();

            DB::commit();

            return redirect()->route('usuario.index')->with('success', '¡El registro fue creado exitosamente!');
        } catch (\Exception $th) {
            DB::rollback();
            if ($th instanceof QueryException)
                return redirect()->route('usuario.create')->with('danger', $th->getMessage());
            else
                return redirect()->route('usuario.create')->with('danger', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\escuela\seguridad\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function show(Usuario $usuario)
    {
        try {
            DB::beginTransaction();

            if ($usuario->activo) {
                $message = '¡El registro fue desactivado exitosamente!';
                $usuario->activo = false;
            } else {
                $message = '¡El registro fue activado exitosamente!';
                $usuario->activo = true;
            }

            $usuario->save();

            DB::commit();

            return redirect()->route('usuario.index')->with('success', $message);
        } catch (\Exception $th) {
            DB::rollback();
            if ($th instanceof QueryException)
                return redirect()->route('usuario.index')->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('usuario.index')->with('danger', $th->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\escuela\seguridad\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function edit(Usuario $usuario)
    {
        try {
            $municipios = Municipio::all();
            $roles = Rol::all();
            $persona = Persona::find($usuario->persona_id);

            return view('escuela.seguridad.usuario.edit', ['usuario' => $usuario, 'municipios' => $municipios, 'persona' => $persona, 'roles' => $roles]);
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('usuario.index')->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('usuario.index')->with('danger', $th->getMessage());
        }
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
        $this->validate(
            $request,
            [
                'nombre' => 'required|max:40',
                'apellido' => 'required|max:40',
                'email' => 'required|max:50|email|unique:usuario,email,' .  $usuario->id,
                'fecha_nacimiento' => 'required|date_format:d-m-Y',
                'domicilio' => 'max:100',
                'telefono' => 'nullable|digits_between:8,8',
                'municipio_id' => 'required|integer|exists:municipio,id',
                'rol_id' => 'required|integer|exists:rol,id',
                'password' => 'min:6|max:15'
            ]
        );

        try {

            DB::beginTransaction();

            $persona = Persona::find($usuario->persona_id);
            $persona->nombre = $request->nombre;
            $persona->apellido = $request->apellido;
            $persona->email = $request->email;
            $persona->fecha_nacimiento = date('Y-m-d', strtotime($request->fecha_nacimiento));
            $persona->domicilio = $request->domicilio;
            $persona->telefono = $request->telefono;
            $persona->municipio_id = $request->municipio_id;
            $persona->save();

            $usuario->email = $persona->email;
            if(isset($request->password) && !is_null($request->password) && empty($request->password)) {
                $usuario->password = $request->password;
            }
            $usuario->rol_id = $request->rol_id;
            $usuario->nombre_completo = "{$persona->nombre} {$persona->apellido}";
            $usuario->save();

            DB::commit();

            return redirect()->route('usuario.index')->with('success', '¡El registro fue actualizado exitosamente!');
        } catch (\Exception $th) {
            DB::rollback();
            if ($th instanceof QueryException)
                return redirect()->route('usuario.create')->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('usuario.create')->with('danger', $th->getMessage());
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\escuela\seguridad\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Usuario $usuario)
    {
        try {
            $usuario->delete();

            return redirect()->route('usuario.index')->with('info', '¡El registro fue eliminado exitosamente!');
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('usuario.index')->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('usuario.index')->with('danger', $th->getMessage());
        }
    }
}
