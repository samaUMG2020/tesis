<?php

namespace App\Models\escuela\catalogo;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class CursoGS extends Model
{
    use SearchableTrait;

    protected $searchable = [
        'columns' => [
            'curso_g_s.nombre_completo' => 10,
        ]
    ];

    protected $table = 'curso_g_s';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'nombre_completo', 'grado_seccion_id', 'curso_id'
    ];
}
