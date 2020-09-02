<?php

namespace App\Models\escuela\catalogo;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Seccion extends Model
{
    use SearchableTrait;

    protected $searchable = [
        'columns' => [
            'seccion.nombre' => 10,
        ]
    ];

    protected $table = 'seccion';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'nombre'
    ];

    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] = strtoupper($value);
    }
}
