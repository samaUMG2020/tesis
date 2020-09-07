<?php

namespace App\Models\escuela\catalogo;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class TipoPagoAlumno extends Model
{
    use SearchableTrait;

    protected $searchable = [
        'columns' => [
            'tipo_pago_alumno.nombre' => 20,
        ]
    ];

    protected $table = 'tipo_pago_alumno';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'nombre'
    ];
    
}
