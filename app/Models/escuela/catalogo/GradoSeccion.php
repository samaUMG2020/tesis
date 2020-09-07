<?php

namespace App\Models\escuela\catalogo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Nicolaslopezj\Searchable\SearchableTrait;

class GradoSeccion extends Model
{
    use SearchableTrait;

    protected $searchable = [
        'columns' => [
            'grado_seccion.nombre_completo' => 10,
        ]
    ];

    protected $table = 'grado_seccion';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'nombre_completo', 'seccion_id', 'grado_id'
    ];
    public function grado()
    {
        return $this->belongsTo(Grado::class, 'grado_id', 'id');
    }
    public function seccion()
    {
        return $this->belongsTo(Seccion::class, 'seccion_id', 'id');
    }

}
