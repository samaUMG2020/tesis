<?php

namespace App\Models\escuela\sistema;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Alumno extends Model
{
    use SearchableTrait;

    protected $searchable = [
        'columns' => [
            'alumno.nombre_completo' => 10,
        ]
    ];

    protected $table = 'alumno';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'codigo', 'nombre_completo', 'persona_id'
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_id', 'id');
    }
}
