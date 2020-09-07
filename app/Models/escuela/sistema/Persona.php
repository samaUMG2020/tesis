<?php

namespace App\Models\escuela\sistema;

use App\Models\escuela\catalogo\Municipio;
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
        'domicilio', 'telefono', 'municipio_id'
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date: d/m/Y'
    ];

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    public function municipio()
    {
        return $this->belongsTo(Municipio::class,'minicipio_id', 'id');
    }

}
