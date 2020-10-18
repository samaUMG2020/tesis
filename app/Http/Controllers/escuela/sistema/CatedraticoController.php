<?php

namespace App\Http\Controllers\escuela\sistema;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\escuela\sistema\Persona;
use Illuminate\Database\QueryException;
use App\Models\escuela\catalogo\Municipio;
use App\Models\escuela\sistema\Catedratico;
use App\Models\escuela\sistema\CatedraticoCurso;

class CatedraticoController extends Controller
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
                $values = Catedratico::search($request->buscar)->orderBy('created_at', 'DESC')->paginate(15);
            else
                $values = Catedratico::orderBy('created_at', 'DESC')->paginate(15);

            return view('escuela.sistema.catedratico.index ', ['values' => $values]);
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

            return view('escuela.sistema.catedratico.create', compact('municipios'));
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('catedratico.index')->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('catedratico.index')->with('danger', $th->getMessage());
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
                'codigo' => 'required|digits_between:4,8|unique:catedratico,codigo',
                'nombre' => 'required|max:40',
                'apellido' => 'required|max:40',
                'email' => 'nullable|max:50|email',
                'fecha_nacimiento' => 'required|date_format:d-m-Y',
                'domicilio' => 'max:100',
                'telefono' => 'nullable|digits_between:8,8',
                'municipio_id' => 'required|integer|exists:municipio,id'
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

            $catedratico = new Catedratico();
            $catedratico->codigo = $request->codigo;
            $catedratico->nombre_completo = "{$persona->nombre} {$persona->apellido}";
            $catedratico->persona_id = $persona->id;
            $catedratico->activo = true;
            $catedratico->save();

            DB::commit();

            return redirect()->route('catedratico.index')->with('success', '¡El registro fue creado exitosamente!');
        } catch (\Exception $th) {
            DB::rollback();
            if ($th instanceof QueryException)
                return redirect()->route('catedratico.create')->with('danger', $th->getMessage());
            else
                return redirect()->route('catedratico.create')->with('danger', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\escuela\sistema\Catedratico  $catedratico
     * @return \Illuminate\Http\Response
     */
    public function show(Catedratico $catedratico)
    {
        try {
            DB::beginTransaction();

            if($catedratico->activo) {
                CatedraticoCurso::where('catedratico_id', $catedratico->id)->update(['activo' => false]);
                $message = '¡El registro fue desactivado exitosamente!';
                $catedratico->activo = false;
            } else {
                $ids = CatedraticoCurso::where('catedratico_id', $catedratico->id)->pluck('curso_g_s_id');
                CatedraticoCurso::whereIn('curso_g_s_id', $ids)->update(['activo' => false]);
                CatedraticoCurso::where('catedratico_id', $catedratico->id)->update(['activo' => true]);
                $message = '¡El registro fue activado exitosamente!';
                $catedratico->activo = true;
            }

            $catedratico->save();

            DB::commit();

            return redirect()->route('catedratico.index')->with('success', $message);
        } catch (\Exception $th) {
            DB::rollback();
            if ($th instanceof QueryException)
                return redirect()->route('catedratico.index')->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('catedratico.index')->with('danger', $th->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\escuela\sistema\Catedratico  $catedratico
     * @return \Illuminate\Http\Response
     */
    public function edit(Catedratico $catedratico)
    {
        try {
            $municipios = Municipio::all();
            $persona = Persona::find($catedratico->persona_id);
            
            return view('escuela.sistema.catedratico.edit', ['catedratico' => $catedratico, 'municipios' => $municipios, 'persona' => $persona]);
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('catedratico.index')->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('catedratico.index')->with('danger', $th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\escuela\sistema\Catedratico  $catedratico
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Catedratico $catedratico)
    {
        $this->validate(
            $request,
            [
                'nombre' => 'required|max:40',
                'codigo' => 'required|integer|digits_between:4,8|unique:catedratico,codigo,'. $catedratico->id,
                'apellido' => 'required|max:40',
                'email' => 'nullable|max:50|email',
                'fecha_nacimiento' => 'required|date_format:d-m-Y',
                'domicilio' => 'max:100',
                'telefono' => 'nullable|digits_between:8,8',
                'municipio_id' => 'required|integer|exists:municipio,id'
            ]
        );

        try {

            DB::beginTransaction();

            $catedratico->codigo = $request->codigo;
            $catedratico->nombre_completo = "{$request->nombre} {$request->apellido}";
            $catedratico->save();

            $persona = Persona::find($catedratico->persona_id);
            $persona->nombre = $request->nombre;
            $persona->apellido = $request->apellido;
            $persona->email = $request->email;
            $persona->fecha_nacimiento = date('Y-m-d', strtotime($request->fecha_nacimiento));
            $persona->domicilio = $request->domicilio;
            $persona->telefono = $request->telefono;
            $persona->municipio_id = $request->municipio_id;
            $persona->save();

            DB::commit();

            return redirect()->route('catedratico.index')->with('success', '¡El registro fue actualizado exitosamente!');
        } catch (\Exception $th) {
            DB::rollback();
            if ($th instanceof QueryException)
                return redirect()->route('catedratico.create')->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('catedratico.create')->with('danger', $th->getMessage());
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\escuela\sistema\Catedratico  $catedratico
     * @return \Illuminate\Http\Response
     */
    public function destroy(Catedratico $catedratico)
    {
        try {
            $cursos = CatedraticoCurso::where('catedratico_id', $catedratico->id)->get();

            if (count($cursos) > 0)
                return redirect()->route('alumno.index')->with('warning', '¡El alumno tiene registros en el sistema!');
            else
                $catedratico->delete();

            return redirect()->route('catedratico.index')->with('info', '¡El registro fue eliminado exitosamente!');
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('catedratico.index')->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('catedratico.index')->with('danger', $th->getMessage());
        }
    }
}
