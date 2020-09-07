<?php

namespace App\Models\escuela\sistema;

use App\Models\escuela\catalogo\TipoFondo;
use Illuminate\Database\Eloquent\Model;

class Fondo extends Model
{
    protected $table = 'fondo';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

     protected $fillable = [
         'cantiadad', 'tipo_fondo_id', 'anio'
    ];

    public function tipo_fondo()
    {
        return $this->belongsTo(TipoFondo::class, 'tipo_fondo_id', 'id');
    }
}
