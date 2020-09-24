<?php

namespace App\Models\escuela\sistema;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\escuela\catalogo\Municipio;
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

    public function fechaPersona()
    {
        return date('d-m-Y', strtotime($this->fecha_nacimiento));
    }

    public function edadPersona()
    {
        return Carbon::parse($this->fecha_nacimiento)->age;
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    public function municipio()
    {
        return $this->belongsTo(Municipio::class,'municipio_id', 'id');
    }

}
