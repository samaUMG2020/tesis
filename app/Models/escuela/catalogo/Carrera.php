<?php

namespace App\Models\escuela\catalogo;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Carrera extends Model
{
    use SearchableTrait;

    protected $searchable = [
        'columns' => [
            'carrera.nombre' => 10,
        ]
    ];

    protected $table = 'carrera';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'nombre'
    ];
}
