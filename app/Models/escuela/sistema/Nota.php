<?php

namespace App\Models\escuela\sistema;

use App\Models\escuela\catalogo\Bimestre;
use App\Models\escuela\catalogo\Curso;
use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    protected $table = 'notas';

    protected $fillable = [
        'nota', 'anio', 'alumno_grado_id', 'curso_id', 'bimestre_id'
    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'curso_id', 'id');
    }

    public function bimestre()
    {
        return $this->belongsTo(Bimestre::class, 'bimestre_id', 'id');
    }

    public function alumno_grado()
    {
        return $this->belongsTo(AlumnoGrado::class, 'alumno_grado_id', 'id');
    }
}