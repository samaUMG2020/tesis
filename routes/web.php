<?php

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
Route::resource('grado', 'escuela\catalogo\GradoController');
Route::resource('seccion', 'escuela\catalogo\SeccionController');
