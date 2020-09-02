<?php

namespace App\Models\escuela\sistema;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Persona extends Model
{
    use SearchableTrait;

    protected $searchable = [
        'columns' => [
            'persona.nombre' => 10,
            'persona.apellido' => 10,
            'persona.email' => 15,
        ]
    ];

    protected $table = 'persona';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'nombre', 'apellido', 'email', 'fecha_nacimiento', 
        'domicilio', 'telelfono', 'municipio_id'
    ];

    protected $casts = [
        'fecha_nacimiento' => 'datetime: d/m/Y'
    ];

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }
}
