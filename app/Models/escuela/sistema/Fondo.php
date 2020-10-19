<?php

namespace App\Models\escuela\sistema;

use Illuminate\Database\Eloquent\Model;
use App\Models\escuela\catalogo\TipoFondo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;

class Fondo extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'fondos';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

     protected $fillable = [
        'cantidad', 'tipo_fondo_id', 'anio'
    ];

    public function tipo_fondo()
    {
        return $this->belongsTo(TipoFondo::class, 'tipo_fondo_id', 'id');
    }
}
