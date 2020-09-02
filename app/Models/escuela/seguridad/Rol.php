<?php

namespace App\Models\escuela\seguridad;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Rol extends Model
{
    use SearchableTrait;

    protected $searchable = [
        'columns' => [
            'rol.nombre' => 10,
        ]
    ];

    protected $table = 'rol';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'nombre'
    ];
}
