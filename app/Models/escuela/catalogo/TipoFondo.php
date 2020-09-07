<?php

namespace App\Models\escuela\catalogo;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class TipoFondo extends Model
{
    use SearchableTrait;

    protected $searchable = [
        'columns' => [
            'tipo_fondo.nombre' => 20,
        ]
    ];

    protected $table = 'tipo_fondo';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'nombre'
    ];
}
