<?php

namespace App\Http\Controllers\escuela\catalogo;

use App\Http\Controllers\Controller;
use App\Models\escuela\catalogo\Bimestre;
use Illuminate\Http\Request;

class BimestreController extends Controller
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
        $values = Bimestre::search($request->buscar)->orderBy('created_at', 'DESC')->paginate(10);
        else
            $values = Bimestre::orderBy('created_at', 'DESC')->paginate(10);

        return view('escuela.catalogo.bimestre.index', compact('values'));
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
     * @param  \App\Models\escuela\catalogo\Bimestre  $bimestre
     * @return \Illuminate\Http\Response
     */
    public function show(Bimestre $bimestre)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\escuela\catalogo\Bimestre  $bimestre
     * @return \Illuminate\Http\Response
     */
    public function edit(Bimestre $bimestre)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\escuela\catalogo\Bimestre  $bimestre
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bimestre $bimestre)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\escuela\catalogo\Bimestre  $bimestre
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bimestre $bimestre)
    {
        //
    }
}
