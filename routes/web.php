<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::get('/', 'HomeController@index')->name('home');
Route::resource('bimestre', 'escuela\catalogo\BimestreController'); //REALIZADO EL 09/09
Route::resource('carrera', 'escuela\catalogo\CarreraController'); //REALIZADO EL 09/09
Route::resource('curso', 'escuela\catalogo\CursoController'); //REALIZADO EL 09/09
Route::resource('cursoGS', 'escuela\catalogo\CursoGSController'); //REALIZADO EL 09/09
Route::resource('departamento', 'escuela\catalogo\DepartamentoController'); //REALIZADO EL 10/09
Route::resource('grado', 'escuela\catalogo\GradoController'); //REALIZADO EL 10/09
Route::resource('gradoSeccion', 'escuela\catalogo\GradoSeccionController'); //REALIZADO EL 10/09
Route::resource('mes','escuela\catalogo\MesController'); //REALIZADO EL 10/09
Route::resource('seccion', 'escuela\catalogo\SeccionController'); //REALIZADO EL 11/09
Route::resource('tipoFondo', 'escuela\catalogo\tipoFondoController'); //REALIZADO EL 11/09
Route::resource('tipoPagoAlumno', 'escuela\catalogo\tipoPagoAlumnoController'); //REALIZADO EL 11/09

Route::resource('rol', 'escuela\seguridad\RolController'); //REALIZADO EL 11/09
Route::resource('usuario', 'escuela\seguridad\UsuarioController'); //REALIZADO EL 12/09

Route::resource('alumno', 'escuela\sistema\AlumnoController'); //REALIZADO EL 12/09
Route::resource('alumnoGrado', 'escuela\sistema\alumnoGradoController'); //REALIZADO EL 12/09
Route::resource('catedratico', 'escuela\sistema\CatedraticoController'); //REALIZADO EL 12/09
Route::resource('catedraticoCurso','escuela\sistema\CatedraticoCursoController'); //REALIZADO EL 13/09
Route::resource('catedraticoCurso','escuela\sistema\CatedraticoCursoController'); //REALIZADO EL 13/09
Route::resource('fondo','escuela\sistema\fondoController'); //REALIZADO EL 13/09
Route::resource('nota','escuela\sistema\notaController'); //REALIZADO EL 13/09
Route::resource('inscripcion', 'escuela\sistema\InscripcionController'); //REALIZADO EL 14/09
Route::name('inscripcion.create_siguiente')->get('create_siguiente/inscripcion', 'escuela\sistema\InscripcionController@create_siguiente'); //REALIZADO EL 14/09
Route::name('inscripcion.store_siguiente')->post('store_siguiente/inscripcion', 'escuela\sistema\InscripcionController@store_siguiente'); //REALIZADO EL 14/09
Route::resource('mensualidad', 'escuela\sistema\MensualidadController'); //REALIZADO EL 14/09
Route::resource('pagoCatedratico','escuela\sistema\pagoCatedraticoController'); //REALIZADO EL 14/09
Route::resource('persona','escuela\sistema\PersonaController'); //REALIZADO EL 14/09
Route::resource('municipio','escuela\catalogo\MunicipioController'); //REALIZADO EL 14/09
Route::resource('promedio','escuela\sistema\PromedioController'); //REALIZADO EL 14/09






