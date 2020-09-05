<?php

namespace App\Models\escuela\sistema;

use App\Models\escuela\catalogo\GradoSeccion;
use Illuminate\Database\Eloquent\Model;

class AlumnoGrado extends Model
{
    protected $table = 'alumno_grado';

    protected $fillable = [
        'anio', 'grado_seccion_id', 'alumno_id'
    ];

    public function grado_seccion()
    {
        return $this->belongsTo(GradoSeccion::class, 'grado_seccion_id', 'id');
    }

    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'alumno_id', 'id');
    }
}
