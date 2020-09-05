<?php

namespace App\Models\escuela\catalogo;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Mes extends Model
{
    use SearchableTrait;

    protected $searchable = [
        'columns' => [
            'mes.nombre' => 10,
        ]
    ];

    protected $table = 'mes';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'nombre'
    ];
}