<?php

namespace App\Models\escuela\catalogo;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Departamento extends Model
{
    use SearchableTrait;

    protected $searchable = [
        'columns' => [
            'departamento.nombre' => 10,
        ]
    ];

    protected $table = 'departamento';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'nombre'
    ];
}
