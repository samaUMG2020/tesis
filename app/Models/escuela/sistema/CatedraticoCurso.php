<?php

namespace App\Models\escuela\sistema;

use App\Models\escuela\catalogo\CursoGS;
use Illuminate\Database\Eloquent\Model;

class CatedraticoCurso extends Model
{
    protected $table = 'catedratico_curso';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'curso_g_s_id', 'catedratico_id'
    ];

    public function curso()
    {
        return $this->belongsTo(CursoGS::class, 'curso_g_s_id', 'id');
    }

    public function catedratico()
    {
        return $this->belongsTo(Catedratico::class, 'catedratico_id', 'id');
    }
}
