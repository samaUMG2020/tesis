<?php

namespace App\Http\Controllers\escuela\sistema;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\escuela\sistema\Alumno;
use App\Models\escuela\sistema\Persona;
use Illuminate\Database\QueryException;
use App\Models\escuela\catalogo\Municipio;
use App\Models\escuela\sistema\PagoAlumno;

class AlumnoController extends Controller
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
                $values = Alumno::search($request->buscar)->where('graduado', false)->orderBy('created_at', 'DESC')->paginate(15);
            else
                $values = Alumno::where('graduado', false)->orderBy('created_at', 'DESC')->paginate(15);

            return view('escuela.sistema.alumno.index ', ['values' => $values]);
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

            return view('escuela.sistema.alumno.create', compact('municipios'));
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('alumno.index')->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('alumno.index')->with('danger', $th->getMessage());
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
                'codigo' => 'required|digits_between:4,8|unique:alumno,codigo',
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

            $alumno = new Alumno();
            $alumno->codigo = $request->codigo;
            $alumno->nombre_completo = "{$persona->nombre} {$persona->apellido}";
            $alumno->persona_id = $persona->id;
            $alumno->save();

            DB::commit();

            return redirect()->route('alumno.index')->with('success', '¡El registro fue creado exitosamente!');
        } catch (\Exception $th) {
            DB::rollback();
            if ($th instanceof QueryException)
                return redirect()->route('alumno.create')->with('danger', $th->getMessage());
            else
                return redirect()->route('alumno.create')->with('danger', $th->getMessage());
        }        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\escuela\sistema\Alumno  $alumno
     * @return \Illuminate\Http\Response
     */
    public function show(Alumno $alumno)
    {
        //
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\escuela\sistema\Alumno  $alumno
     * @return \Illuminate\Http\Response
     */
    public function edit(Alumno $alumno)
    {
        try {
            $municipios = Municipio::all();
            $persona = Persona::find($alumno->persona_id);

            return view('escuela.sistema.alumno.edit', ['alumno' => $alumno, 'municipios' => $municipios, 'persona' => $persona]);
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('alumno.index')->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('alumno.index')->with('danger', $th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\escuela\sistema\Alumno  $alumno
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Alumno $alumno)
    {
        $this->validate(
            $request,
            [
                'nombre' => 'required|max:40',
                'codigo' => 'required|integer|digits_between:4,8|unique:alumno,codigo,'.$alumno->id,
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

            $alumno->codigo = $request->codigo;
            $alumno->nombre_completo = "{$request->nombre} {$request->apellido}";
            $alumno->save();

            $persona = Persona::find($alumno->persona_id);
            $persona->nombre = $request->nombre;
            $persona->apellido = $request->apellido;
            $persona->email = $request->email;
            $persona->fecha_nacimiento = date('Y-m-d', strtotime($request->fecha_nacimiento));
            $persona->domicilio = $request->domicilio;
            $persona->telefono = $request->telefono;
            $persona->municipio_id = $request->municipio_id;
            $persona->save();

            DB::commit();

            return redirect()->route('alumno.index')->with('success', '¡El registro fue actualizado exitosamente!');
        } catch (\Exception $th) {
            DB::rollback();
            if ($th instanceof QueryException)
                return redirect()->route('alumno.create')->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('alumno.create')->with('danger', $th->getMessage());
        } 
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\escuela\sistema\Alumno  $alumno
     * @return \Illuminate\Http\Response
     */
    public function destroy(Alumno $alumno)
    {
        try {

        $inscripciones = PagoAlumno::where('alumno_id', $alumno->id)->get();

        if(count($inscripciones) > 0)
            return redirect()->route('alumno.index')->with('warning', '¡El alumno tiene registros en el sistema!');
        else
            $alumno->delete();

        return redirect()->route('alumno.index')->with('info', '¡El registro fue eliminado exitosamente!');
        } catch (\Exception $th) {
        if ($th instanceof QueryException)
            return redirect()->route('alumno.index')->with('danger', 'Error en la base de datos');
        else
            return redirect()->route('alumno.index')->with('danger', $th->getMessage());
        }
    }
}
