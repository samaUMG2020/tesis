<?php

namespace App\Models\escuela\sistema;

use App\Models\escuela\catalogo\Curso;
use Illuminate\Database\Eloquent\Model;

class Promedio extends Model
{
    protected $table = 'promedio';

    protected $fillable = [
        'promedio', 'anio', 'bimestres', 'alumno_grado_id', 'curso_id'
    ];

    public function alumno_grado()
    {
        return $this->belongsTo(AlumnoGrado::class, 'alumno_grado_id', 'id');
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'curso_id', 'id');
    }


}
