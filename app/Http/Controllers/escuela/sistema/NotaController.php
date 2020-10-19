<?php

namespace App\Http\Controllers\escuela\sistema;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\escuela\sistema\Nota;
use App\Models\escuela\catalogo\Curso;
use Illuminate\Database\QueryException;
use App\Models\escuela\catalogo\Bimestre;
use App\Models\escuela\catalogo\GradoSeccion;
use App\Models\escuela\sistema\Promedio;

class NotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $this->validate(
            $request,
            [
                'grado_seccion_id' => 'required|integer|exists:grado_seccion,id'
            ]
        );

        $bimestres = Bimestre::all();
        $message =
            [
                'nota0.*.required' => 'Es necesario las notas del primer bimestre',
                'nota0.*.numeric' => 'Solo se aceptan números en las notas del primer bimestre',
                'nota0.*.between' => 'En las notras del primer bimestre la nota más baja es 0 y la más alta es 100',

                'nota1.*.required' => 'Es necesario las notas del segundo bimestre',
                'nota1.*.numeric' => 'Solo se aceptan números en las notas del segundo bimestre',
                'nota1.*.between' => 'En las notras del segundo bimestre la nota más baja es 0 y la más alta es 100',

                'nota2.*.required' => 'Es necesario las notas del tercer bimestre',
                'nota2.*.numeric' => 'Solo se aceptan números en las notas del tercer bimestre',
                'nota2.*.between' => 'En las notras del tercer bimestre la nota más baja es 0 y la más alta es 100',

                'nota3.*.required' => 'Es necesario las notas del cuarto bimestre',
                'nota3.*.numeric' => 'Solo se aceptan números en las notas del cuarto bimestre',
                'nota3.*.between' => 'En las notras del cuarto bimestre la nota más baja es 0 y la más alta es 100'
            ];

        switch (count($bimestres)) {
            case 1:
                $this->validate(
                    $request,
                    [
                        'nota0.*' => 'required|numeric|between:0,100'
                    ],
                    $message
                );
                break;
            case 2:
                $this->validate(
                    $request,
                    [
                        'nota0.*' => 'required|numeric|between:0,100',
                        'nota1.*' => 'required|numeric|between:0,100'
                    ],
                    $message
                );
                break;
            case 3:
                $this->validate(
                    $request,
                    [
                        'nota0.*' => 'required|numeric|between:0,100',
                        'nota1.*' => 'required|numeric|between:0,100',
                        'nota2.*' => 'required|numeric|between:0,100'
                    ],
                    $message
                );
                break;
            case 4:
                $this->validate(
                    $request,
                    [
                        'nota0.*' => 'required|numeric|between:0,100',
                        'nota1.*' => 'required|numeric|between:0,100',
                        'nota2.*' => 'required|numeric|between:0,100',
                        'nota3.*' => 'required|numeric|between:0,100'
                    ],
                    $message
                );
                break;
            
            default:
                return redirect()->route('cursoGS.show', $request->grado_seccion_id)->with('danger', "Error al validar la información de las notas");
                break;
        }

        $this->validate(
            $request,
            [
                'curso_id' => 'required|integer|exists:curso,id',
                'alumno_grado_id.*' => 'required|integer|exists:alumno_grado,id'
            ]
        );

        try {

            DB::beginTransaction();

            $anio_actual = date('Y');
            $bimestres = Bimestre::all();
            $promedio = 0;

            switch (count($bimestres)) {
                case 1:
                        for ($i=0; $i < count($request->alumno_grado_id); $i++) { 
                            $primer_bimestre = Nota::where(
                                [
                                    'alumno_grado_id' => $request->alumno_grado_id[$i], 
                                    'curso_id' => $request->curso_id, 
                                    'bimestre_id' => 1, 
                                    'anio' => $anio_actual
                                ])->first();

                            if(is_null($primer_bimestre)) {
                                $primer_bimestre = new Nota();
                                $primer_bimestre->nota = $request->nota0[$i];
                                $primer_bimestre->anio = $anio_actual;
                                $primer_bimestre->alumno_grado_id = $request->alumno_grado_id[$i];
                                $primer_bimestre->curso_id = $request->curso_id;
                                $primer_bimestre->bimestre_id = 1;
                                $primer_bimestre->save();
                            } else {
                                $primer_bimestre->nota = $request->nota0[$i];
                                $primer_bimestre->save();
                            }

                            $promedio = $primer_bimestre->nota / 1;
                            $existe_promedio = Promedio::where(
                                [
                                    'alumno_grado_id' => $request->alumno_grado_id[$i],
                                    'curso_id' => $request->curso_id, 
                                    'anio' => $anio_actual
                                ])->first();

                            if(is_null($existe_promedio)) {
                                $existe_promedio = new Promedio();
                                $existe_promedio->promedio = $promedio;
                                $existe_promedio->anio = $anio_actual;
                                $existe_promedio->alumno_grado_id = $request->alumno_grado_id[$i];
                                $existe_promedio->curso_id = $request->curso_id;
                                $existe_promedio->bimestres = 1;
                                $existe_promedio->save();
                            } else {
                                $existe_promedio->promedio = $promedio;
                                $existe_promedio->bimestres = 1;
                                $existe_promedio->save();
                            }
                        }
                    break;
                case 2:
                        for ($i=0; $i < count($request->alumno_grado_id); $i++) { 
                            $primer_bimestre = Nota::where(
                                [
                                    'alumno_grado_id' => $request->alumno_grado_id[$i], 
                                    'curso_id' => $request->curso_id, 
                                    'bimestre_id' => 1, 
                                    'anio' => $anio_actual
                                ])->first();

                            if(is_null($primer_bimestre)) {
                                $primer_bimestre = new Nota();
                                $primer_bimestre->nota = $request->nota0[$i];
                                $primer_bimestre->anio = $anio_actual;
                                $primer_bimestre->alumno_grado_id = $request->alumno_grado_id[$i];
                                $primer_bimestre->curso_id = $request->curso_id;
                                $primer_bimestre->bimestre_id = 1;
                                $primer_bimestre->save();
                            } else {
                                $primer_bimestre->nota = $request->nota0[$i];
                                $primer_bimestre->save();
                            }
                            
                            $segundo_bimestre = Nota::where(
                                [
                                    'alumno_grado_id' => $request->alumno_grado_id[$i], 
                                    'curso_id' => $request->curso_id, 
                                    'bimestre_id' => 2, 
                                    'anio' => $anio_actual
                                ])->first();

                            if(is_null($segundo_bimestre)) {
                                $segundo_bimestre = new Nota();
                                $segundo_bimestre->nota = $request->nota1[$i];
                                $segundo_bimestre->anio = $anio_actual;
                                $segundo_bimestre->alumno_grado_id = $request->alumno_grado_id[$i];
                                $segundo_bimestre->curso_id = $request->curso_id;
                                $segundo_bimestre->bimestre_id = 2;
                                $segundo_bimestre->save();
                            } else {
                                $segundo_bimestre->nota = $request->nota1[$i];
                                $segundo_bimestre->save();
                            }

                            $promedio = ($primer_bimestre->nota + $segundo_bimestre->nota) / 2;
                            $existe_promedio = Promedio::where(
                                [
                                    'alumno_grado_id' => $request->alumno_grado_id[$i],
                                    'curso_id' => $request->curso_id, 
                                    'anio' => $anio_actual
                                ])->first();

                            if(is_null($existe_promedio)) {
                                $existe_promedio = new Promedio();
                                $existe_promedio->promedio = $promedio;
                                $existe_promedio->anio = $anio_actual;
                                $existe_promedio->alumno_grado_id = $request->alumno_grado_id[$i];
                                $existe_promedio->curso_id = $request->curso_id;
                                $existe_promedio->bimestres = 2;
                                $existe_promedio->save();
                            } else {
                                $existe_promedio->promedio = $promedio;
                                $existe_promedio->bimestres = 2;
                                $existe_promedio->save();
                            }
                        }
                    break;
                case 3:
                    for ($i = 0; $i < count($request->alumno_grado_id); $i++) {
                        $primer_bimestre = Nota::where(
                            [
                                'alumno_grado_id' => $request->alumno_grado_id[$i],
                                'curso_id' => $request->curso_id,
                                'bimestre_id' => 1,
                                'anio' => $anio_actual
                            ]
                        )->first();

                        if (is_null($primer_bimestre)) {
                            $primer_bimestre = new Nota();
                            $primer_bimestre->nota = $request->nota0[$i];
                            $primer_bimestre->anio = $anio_actual;
                            $primer_bimestre->alumno_grado_id = $request->alumno_grado_id[$i];
                            $primer_bimestre->curso_id = $request->curso_id;
                            $primer_bimestre->bimestre_id = 1;
                            $primer_bimestre->save();
                        } else {
                            $primer_bimestre->nota = $request->nota0[$i];
                            $primer_bimestre->save();
                        }

                        $segundo_bimestre = Nota::where(
                            [
                                'alumno_grado_id' => $request->alumno_grado_id[$i],
                                'curso_id' => $request->curso_id,
                                'bimestre_id' => 2,
                                'anio' => $anio_actual
                            ]
                        )->first();

                        if (is_null($segundo_bimestre)) {
                            $segundo_bimestre = new Nota();
                            $segundo_bimestre->nota = $request->nota1[$i];
                            $segundo_bimestre->anio = $anio_actual;
                            $segundo_bimestre->alumno_grado_id = $request->alumno_grado_id[$i];
                            $segundo_bimestre->curso_id = $request->curso_id;
                            $segundo_bimestre->bimestre_id = 2;
                            $segundo_bimestre->save();
                        } else {
                            $segundo_bimestre->nota = $request->nota1[$i];
                            $segundo_bimestre->save();
                        }

                        $tercer_bimestre = Nota::where(
                            [
                                'alumno_grado_id' => $request->alumno_grado_id[$i],
                                'curso_id' => $request->curso_id,
                                'bimestre_id' => 3,
                                'anio' => $anio_actual
                            ]
                        )->first();

                        if (is_null($tercer_bimestre)) {
                            $tercer_bimestre = new Nota();
                            $tercer_bimestre->nota = $request->nota2[$i];
                            $tercer_bimestre->anio = $anio_actual;
                            $tercer_bimestre->alumno_grado_id = $request->alumno_grado_id[$i];
                            $tercer_bimestre->curso_id = $request->curso_id;
                            $tercer_bimestre->bimestre_id = 3;
                            $tercer_bimestre->save();
                        } else {
                            $tercer_bimestre->nota = $request->nota2[$i];
                            $tercer_bimestre->save();
                        }

                        $promedio = ($primer_bimestre->nota + $segundo_bimestre->nota + $tercer_bimestre->nota) / 3;
                        $existe_promedio = Promedio::where(
                            [
                                'alumno_grado_id' => $request->alumno_grado_id[$i],
                                'curso_id' => $request->curso_id,
                                'anio' => $anio_actual
                            ]
                        )->first();

                        if (is_null($existe_promedio)) {
                            $existe_promedio = new Promedio();
                            $existe_promedio->promedio = $promedio;
                            $existe_promedio->anio = $anio_actual;
                            $existe_promedio->alumno_grado_id = $request->alumno_grado_id[$i];
                            $existe_promedio->curso_id = $request->curso_id;
                            $existe_promedio->bimestres = 3;
                            $existe_promedio->save();
                        } else {
                            $existe_promedio->promedio = $promedio;
                            $existe_promedio->bimestres = 3;
                            $existe_promedio->save();
                        }
                    }
                    break;
                case 4:
                    for ($i = 0; $i < count($request->alumno_grado_id); $i++) {
                        $primer_bimestre = Nota::where(
                            [
                                'alumno_grado_id' => $request->alumno_grado_id[$i],
                                'curso_id' => $request->curso_id,
                                'bimestre_id' => 1,
                                'anio' => $anio_actual
                            ]
                        )->first();

                        if (is_null($primer_bimestre)) {
                            $primer_bimestre = new Nota();
                            $primer_bimestre->nota = $request->nota0[$i];
                            $primer_bimestre->anio = $anio_actual;
                            $primer_bimestre->alumno_grado_id = $request->alumno_grado_id[$i];
                            $primer_bimestre->curso_id = $request->curso_id;
                            $primer_bimestre->bimestre_id = 1;
                            $primer_bimestre->save();
                        } else {
                            $primer_bimestre->nota = $request->nota0[$i];
                            $primer_bimestre->save();
                        }

                        $segundo_bimestre = Nota::where(
                            [
                                'alumno_grado_id' => $request->alumno_grado_id[$i],
                                'curso_id' => $request->curso_id,
                                'bimestre_id' => 2,
                                'anio' => $anio_actual
                            ]
                        )->first();

                        if (is_null($segundo_bimestre)) {
                            $segundo_bimestre = new Nota();
                            $segundo_bimestre->nota = $request->nota1[$i];
                            $segundo_bimestre->anio = $anio_actual;
                            $segundo_bimestre->alumno_grado_id = $request->alumno_grado_id[$i];
                            $segundo_bimestre->curso_id = $request->curso_id;
                            $segundo_bimestre->bimestre_id = 2;
                            $segundo_bimestre->save();
                        } else {
                            $segundo_bimestre->nota = $request->nota1[$i];
                            $segundo_bimestre->save();
                        }

                        $tercer_bimestre = Nota::where(
                            [
                                'alumno_grado_id' => $request->alumno_grado_id[$i],
                                'curso_id' => $request->curso_id,
                                'bimestre_id' => 3,
                                'anio' => $anio_actual
                            ]
                        )->first();

                        if (is_null($tercer_bimestre)) {
                            $tercer_bimestre = new Nota();
                            $tercer_bimestre->nota = $request->nota2[$i];
                            $tercer_bimestre->anio = $anio_actual;
                            $tercer_bimestre->alumno_grado_id = $request->alumno_grado_id[$i];
                            $tercer_bimestre->curso_id = $request->curso_id;
                            $tercer_bimestre->bimestre_id = 3;
                            $tercer_bimestre->save();
                        } else {
                            $tercer_bimestre->nota = $request->nota2[$i];
                            $tercer_bimestre->save();
                        }

                        $cuarto_bimestre = Nota::where(
                            [
                                'alumno_grado_id' => $request->alumno_grado_id[$i],
                                'curso_id' => $request->curso_id,
                                'bimestre_id' => 4,
                                'anio' => $anio_actual
                            ]
                        )->first();

                        if (is_null($cuarto_bimestre)) {
                            $cuarto_bimestre = new Nota();
                            $cuarto_bimestre->nota = $request->nota3[$i];
                            $cuarto_bimestre->anio = $anio_actual;
                            $cuarto_bimestre->alumno_grado_id = $request->alumno_grado_id[$i];
                            $cuarto_bimestre->curso_id = $request->curso_id;
                            $cuarto_bimestre->bimestre_id = 4;
                            $cuarto_bimestre->save();
                        } else {
                            $cuarto_bimestre->nota = $request->nota3[$i];
                            $cuarto_bimestre->save();
                        }

                        $promedio = ($primer_bimestre->nota + $segundo_bimestre->nota + $tercer_bimestre->nota + $cuarto_bimestre->nota) / 4;
                        $existe_promedio = Promedio::where(
                            [
                                'alumno_grado_id' => $request->alumno_grado_id[$i],
                                'curso_id' => $request->curso_id,
                                'anio' => $anio_actual
                            ]
                        )->first();

                        if (is_null($existe_promedio)) {
                            $existe_promedio = new Promedio();
                            $existe_promedio->promedio = $promedio;
                            $existe_promedio->anio = $anio_actual;
                            $existe_promedio->alumno_grado_id = $request->alumno_grado_id[$i];
                            $existe_promedio->curso_id = $request->curso_id;
                            $existe_promedio->bimestres = 4;
                            $existe_promedio->save();
                        } else {
                            $existe_promedio->promedio = $promedio;
                            $existe_promedio->bimestres = 4;
                            $existe_promedio->save();
                        }
                    }
                    break;

            }

            DB::commit();

            return redirect()->route('nota.asignar', ['grado_seccion_id' => $request->grado_seccion_id, 'curso_id' => $request->curso_id])->with('success', '¡El registro fue creado exitosamente!');
        } catch (\Exception $th) {
            DB::rollback();
            if ($th instanceof QueryException)
                return redirect()->route('cursoGS.show', $request->grado_seccion_id)->with('danger', $th->getMessage());
            else
                return redirect()->route('cursoGS.show', $request->grado_seccion_id)->with('danger', "Error al ingresar");
        } 
    }

    public function asignar($grado_seccion_id, $curso_id)
    {
        try {
            $anio_actual = date('Y');
            $grado_seccion = GradoSeccion::find($grado_seccion_id);
            $curso = Curso::find($curso_id);

            $alumnos = DB::table('alumno_grado')
                ->join('alumno', 'alumno_grado.alumno_id', 'alumno.id')
                ->select(
                    'alumno.nombre_completo AS alumno', 
                    'alumno.codigo AS codigo', 
                    'alumno_grado.id AS id',
                    DB::raw("(SELECT notas.nota FROM notas WHERE notas.alumno_grado_id = alumno_grado.id AND notas.curso_id = {$curso->id} AND notas.bimestre_id = 1 AND notas.anio = {$anio_actual}) AS nota0"),
                    DB::raw("(SELECT notas.nota FROM notas WHERE notas.alumno_grado_id = alumno_grado.id AND notas.curso_id = {$curso->id} AND notas.bimestre_id = 2 AND notas.anio = {$anio_actual}) AS nota1"),
                    DB::raw("(SELECT notas.nota FROM notas WHERE notas.alumno_grado_id = alumno_grado.id AND notas.curso_id = {$curso->id} AND notas.bimestre_id = 3 AND notas.anio = {$anio_actual}) AS nota2"),
                    DB::raw("(SELECT notas.nota FROM notas WHERE notas.alumno_grado_id = alumno_grado.id AND notas.curso_id = {$curso->id} AND notas.bimestre_id = 4 AND notas.anio = {$anio_actual}) AS nota3"),
                    DB::raw("(SELECT promedio.promedio FROM promedio WHERE promedio.alumno_grado_id = alumno_grado.id AND promedio.curso_id = {$curso->id} AND promedio.anio = {$anio_actual}) AS promedio")
                )
                ->where('alumno_grado.grado_seccion_id', $grado_seccion->id)
                ->where('alumno_grado.anio', $anio_actual)
                ->get();

            $bimestres = Bimestre::all();

            return view('escuela.sistema.nota.asignar ', ['alumnos' => $alumnos, 'grado_seccion' => $grado_seccion, 'curso' => $curso, 'bimestres' => $bimestres]);
        } catch (\Exception $th) {
            if ($th instanceof QueryException)
                return redirect()->route('alumnoGrado.index')->with('danger', $th->getMessage());
            else
                return redirect()->route('alumnoGrado.index')->with('danger', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\escuela\sistema\Nota  $nota
     * @return \Illuminate\Http\Response
     */
    public function show(Nota $nota)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\escuela\sistema\Nota  $nota
     * @return \Illuminate\Http\Response
     */
    public function edit(Nota $nota)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\escuela\sistema\Nota  $nota
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Nota $nota)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\escuela\sistema\Nota  $nota
     * @return \Illuminate\Http\Response
     */
    public function destroy(Nota $nota)
    {
        //
    }
}
