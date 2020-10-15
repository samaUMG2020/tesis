<?php

namespace App\Models\escuela\sistema;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Alumno extends Model
{
    use SearchableTrait;

    protected $searchable = [
        'columns' => [
            'alumno.codigo' => 15,
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
        'codigo', 'nombre_completo', 'persona_id', 'activo', 'graduado', 'fin_ciclo'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'graduado' => 'boolean',
        'fin_ciclo' => 'boolean'
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_id', 'id');
    }
}
