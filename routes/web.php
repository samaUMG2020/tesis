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
Route::resource('bimestre', 'escuela\catalogo\BimestreController');
Route::resource('carrera', 'escuela\catalogo\CarreraController');
Route::resource('curso', 'escuela\catalogo\CursoController');
Route::resource('cursoGS', 'escuela\catalogo\CursoGSController');
Route::resource('grado', 'escuela\catalogo\GradoController');
Route::resource('grado', 'escuela\catalogo\GradoController');
Route::resource('gradoSeccion', 'escuela\catalogo\GradoSeccionController');
Route::resource('mes','escuela\catalogo\MesController');
Route::resource('seccion', 'escuela\catalogo\SeccionController');
Route::resource('alumno', 'escuela\sistema\AlumnoController');
Route::resource('catedratico', 'escuela\sistema\CatedraticoController');
Route::resource('catedraticoCurso','escuela\sistema\CatedraticoCursoController');
Route::resource('persona','escuela\sistema\PersonaController');