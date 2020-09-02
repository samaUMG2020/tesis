<?php

namespace App\Models\escuela\catalogo;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class GradoSeccion extends Model
{
    use SearchableTrait;

    protected $searchable = [
        'columns' => [
            'grado_seccion.nombre_completo' => 10,
        ]
    ];

    protected $table = 'grado_seccion';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'nombre_completo', 'seccion_id', 'grado_id'
    ];
}
