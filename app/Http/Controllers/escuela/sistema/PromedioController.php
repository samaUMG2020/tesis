<?php

namespace App\Http\Controllers\escuela\sistema;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use App\Models\escuela\sistema\Promedio;

class PromedioController extends Controller
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
    public function index()
    {
        try {
            $values = Promedio::orderBy('anio', 'DESC')->orderBy('promedio', 'DESC')->paginate(25);

            return view('escuela.sistema.promedio.index ', ['values' => $values]);
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('home')->with('danger', $th->getMessage());
            else
                return redirect()->route('home')->with('danger', 'Error en el controlador');
        }
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\escuela\sistema\Promedio  $promedio
     * @return \Illuminate\Http\Response
     */
    public function show(Promedio $promedio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\escuela\sistema\Promedio  $promedio
     * @return \Illuminate\Http\Response
     */
    public function edit(Promedio $promedio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\escuela\sistema\Promedio  $promedio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Promedio $promedio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\escuela\sistema\Promedio  $promedio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Promedio $promedio)
    {
        //
    }
}
