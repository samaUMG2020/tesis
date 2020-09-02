<?php

namespace App\Models\escuela\catalogo;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Bimestre extends Model
{
    use SearchableTrait;

    protected $searchable = [
        'columns' => [
            'bimestre.nombre' => 10,
        ]
    ];

    protected $table = 'bimestre';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'nombre'
    ];
}
