<?php

namespace App\Models\escuela\sistema;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Catedratico extends Model
{
    use SearchableTrait;

    protected $searchable = [
        'columns' => [
            'catedratico.codigo' => 15,
            'catedratico.nombre_completo' => 10,
        ]
    ];

    protected $table = 'catedratico';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'codigo', 'nombre_completo', 'persona_id', 'activo'
    ];

    protected $casts = [
        'activo' => 'boolean'
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_id', 'id');
    }

    public function cursos()
    {
        return $this->hasMany(CatedraticoCurso::class, 'catedratico_id', 'id');
    }
}
