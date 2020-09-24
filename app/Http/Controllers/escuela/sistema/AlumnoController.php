<?php

namespace App\Http\Controllers\escuela\sistema;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\escuela\sistema\Alumno;
use App\Models\escuela\sistema\Persona;
use Illuminate\Database\QueryException;
use App\Models\escuela\catalogo\Municipio;

class AlumnoController extends Controller
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
                $values = Alumno::search($request->buscar)->orderBy('created_at', 'DESC')->paginate(12);
            else
                $values = Alumno::orderBy('created_at', 'DESC')->paginate(12);

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
                'codigo' => 'required|integer|digits_between:4,8|unique:alumno,codigo',
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
                return redirect()->route('alumno.create')->with('danger', 'Error en la base de datos');
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
        //
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
        $persona= Persona::find($request->persona_id);

        $alumno->codigo = $request->codigo;
        $alumno->nombre_completo = "{$persona->nombre} {$alumno->apellido}";
        $alumno->persona_id = $request->persona_id;

        return response()->json(['Registro nuevo' => $alumno, 'Mensaje' => 'Felicidades editaste']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\escuela\sistema\Alumno  $alumno
     * @return \Illuminate\Http\Response
     */
    public function destroy(Alumno $alumno)
    {
        $alumno->delete();
        return response()->json(['Registro eliminado' => $alumno, 'Mensaje' => 'Felicidades eliminaste']);
    }
}
