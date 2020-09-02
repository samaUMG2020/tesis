<?php

namespace App\Models\escuela\catalogo;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Municipio extends Model
{
    use SearchableTrait;

    protected $searchable = [
        'columns' => [
            'municipio.nombre_completo' => 20,
        ]
    ];

    protected $table = 'municipio';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'nombre', 'nombre_completo', 'departamento_id'
    ];
}
