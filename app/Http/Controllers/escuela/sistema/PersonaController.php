<?php

namespace App\Http\Controllers\escuela\sistema;

use App\Http\Controllers\Controller;
use App\Models\escuela\catalogo\Municipio;
use App\Models\escuela\sistema\Persona;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class PersonaController extends Controller
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
                $values = Persona::search($request->buscar)->orderBy('created_at', 'DESC')->paginate(10);
            else
                $values = Persona::orderBy('created_at', 'DESC')->paginate(10);

            return view('escuela.sistema.persona.index ', ['values' => $values]);
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

            return view('escuela.sistema.persona.create', ['municipios' => $municipios]);
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('persona.index')->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('personaS.index')->with('danger', $th->getMessage());
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
                'municipio_id' => 'required|integer|exists:municipio,id'
                
            ]

            );
            try {
                $existe = Persona::where('municipio_id', $request->municipio_id)->first();

                if(!is_null($existe)){
                    return redirect()->route('persona.index')->with('warning', '¡El registro que intenta agregar ya existe!');
                }

                $municipio = Municipio::find($request->municipio_id);

                $insert = new Persona();

                
                $insert ->nombre= $request->nombre;
                $insert ->apellido= $request->apellido;
                $insert ->email= $request->email;
                $insert ->fecha_nacimiento= $request->fecha_nacimiento;
                $insert ->domicilio= $request->domicilio;
                $insert ->telefono= $request->telefono;
                $insert->nombre_completo = "{$municipio->nombre_completo}";
                $insert ->municipio_id= $request->municipio_id;
                $insert->save();

                return redirect()->route('persona.index')->with('success', 'El registro fue creado exitosamente!');
            }catch(\Exception $th){
                if($th instanceof QueryException)
                   return redirect()->route('persona.create')->with('danger', 'Error en la base de datos');
               else 
               return redirect()->route('persona.create')->with('danger', $th->getMessage());
            }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\escuela\sistema\Persona  $persona
     * @return \Illuminate\Http\Response
     */
    public function show(Persona $persona)
    {
        try {

        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('persona.index')->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('persona.index')->with('danger', $th->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\escuela\sistema\Persona  $persona
     * @return \Illuminate\Http\Response
     */
    public function edit(Persona $persona)
    {
        
        try {
            $municipios = Municipio::all();

            return view('escuela.sistema.persona.create', ['municipios' => $municipios]);
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('persona.index')->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('personaS.index')->with('danger', $th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\escuela\sistema\Persona  $persona
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Persona $persona)
    {
        $this->validate(
            $request,
            [
                'municipio_id' => 'required|integer|exists:municipio,id'
                
            ]

            );
            try {
                $existe = Persona::where('municipio_id', $request->municipio_id)->first();

                if(!is_null($existe)){
                    return redirect()->route('persona.index')->with('warning', '¡El registro que intenta agregar ya existe!');
                }

                $municipio = Municipio::find($request->municipio_id);

                $persona ->nombre= $request->nombre;
                $persona ->apellido= $request->apellido;
                $persona ->email= $request->email;
                $persona ->fecha_nacimiento= $request->fecha_nacimiento;
                $persona ->domicilio= $request->domicilio;
                $persona ->telefono= $request->telefono;
                $persona->nombre_completo = "{$municipio->nombre_completo}";
                $persona ->municipio_id= $request->municipio_id;
                $persona->save();

                return redirect()->route('persona.index')->with('success', 'El registro fue actualizado exitosamente!');
            }catch(\Exception $th){
                if($th instanceof QueryException)
                   return redirect()->route('persona.create')->with('danger', 'Error en la base de datos');
               else 
               return redirect()->route('persona.create')->with('danger', $th->getMessage());
            }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\escuela\sistema\Persona  $persona
     * @return \Illuminate\Http\Response
     */
    public function destroy(Persona $persona)
    {
        try {
            $persona->delete();

            return redirect()->route('persona.index')->with('info', '¡El registro fue eliminado exitosamente!');
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('persona.index')->with('danger', 'Error en la base de datos');
            else
                return redirect()->route('persona.index')->with('danger', $th->getMessage());
        }
    }
}
