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

Route::resource('bimestre', 'escuela\catalogo\BimestreController')->except(['create', 'store', 'show', 'edit', 'update', 'destroy']); //REALIZADO EL 09/09
Route::resource('carrera', 'escuela\catalogo\CarreraController')->except(['show']); //REALIZADO EL 09/09
Route::resource('curso', 'escuela\catalogo\CursoController'); //REALIZADO EL 11/09
Route::resource('cursoGS', 'escuela\catalogo\CursoGSController'); //REALIZADO EL 11/09
Route::resource('departamento', 'escuela\catalogo\DepartamentoController'); //REALIZADO EL 12/09
Route::resource('grado', 'escuela\catalogo\GradoController'); //REALIZADO EL 12/09
Route::resource('gradoSeccion', 'escuela\catalogo\GradoSeccionController')->except(['show']); //REALIZADO EL 12/09
Route::resource('mes','escuela\catalogo\MesController'); //REALIZADO EL 12/09
Route::resource('seccion', 'escuela\catalogo\SeccionController')->except(['show']); //REALIZADO EL 13/09
Route::resource('tipoFondo', 'escuela\catalogo\tipoFondoController')->except(['show']); //REALIZADO EL 13/09
Route::resource('tipoPagoAlumno', 'escuela\catalogo\tipoPagoAlumnoController'); //REALIZADO EL 13/09

Route::resource('rol', 'escuela\seguridad\RolController'); //REALIZADO EL 14/09
Route::resource('usuario', 'escuela\seguridad\UsuarioController'); //REALIZADO EL 14/09

Route::resource('alumno', 'escuela\sistema\AlumnoController')->except(['show']); //REALIZADO EL 14/09
Route::resource('alumnoGrado', 'escuela\sistema\alumnoGradoController')->except(['create, store, show, edit, update, destroy']); //REALIZADO EL 14/09
Route::resource('catedratico', 'escuela\sistema\CatedraticoController'); //REALIZADO EL 14/09
Route::resource('catedraticoCurso','escuela\sistema\CatedraticoCursoController')->except(['create, edit, update']); //REALIZADO EL 15/09
Route::resource('catedraticoCurso','escuela\sistema\CatedraticoCursoController')->except(['create, edit, update']); //REALIZADO EL 15/09
Route::resource('fondo','escuela\sistema\fondoController')->except(['create, show, edit, update']); //REALIZADO EL 15/09
Route::resource('nota','escuela\sistema\notaController')->except(['index, create, show, edit, update, destroy']); //REALIZADO EL 15/09
Route::resource('inscripcion', 'escuela\sistema\InscripcionController')->except(['edit, update']); //REALIZADO EL 16/09
Route::name('inscripcion.create_siguiente')->get('create_siguiente/inscripcion', 'escuela\sistema\InscripcionController@create_siguiente'); //REALIZADO EL 
Route::name('inscripcion.store_siguiente')->post('store_siguiente/inscripcion', 'escuela\sistema\InscripcionController@store_siguiente'); //REALIZADO EL 
Route::resource('mensualidad', 'escuela\sistema\MensualidadController')->except(['create, show, edit, update, destroy']); //REALIZADO EL 16/09
Route::resource('pagoCatedratico','escuela\sistema\pagoCatedraticoController')->except(['create, edit, update, destroy']); //REALIZADO EL 17/09
Route::resource('persona','escuela\sistema\PersonaController')->except(['show']); //REALIZADO EL 17/09
Route::resource('municipio','escuela\catalogo\MunicipioController'); //REALIZADO EL 17/09
Route::resource('promedio','escuela\sistema\PromedioController')->except(['create, store, show, edit, update, destroy']); //REALIZADO EL 17/09
