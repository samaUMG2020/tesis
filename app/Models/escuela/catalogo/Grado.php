<?php

namespace App\Models\escuela\catalogo;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Grado extends Model
{
    use SearchableTrait;

    protected $searchable = [
        'columns' => [
            'grado.nombre' => 10,
            'grado.nombre_completo' => 20,
        ]
    ];

    protected $table = 'grado';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'nombre', 'nombre_completo', 'carrera_id'
    ];

    public function carrera()
    {
        return $this->belongsTo(Carrera::class, 'carrera_id', 'id');
    }
   
}
