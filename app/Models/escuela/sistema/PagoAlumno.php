<?php

namespace App\Models\escuela\sistema;

use App\Models\escuela\catalogo\Grado;
use App\Models\escuela\catalogo\Mes;
use Illuminate\Database\Eloquent\Model;

class PagoAlumno extends Model
{
    protected $table = 'pago_alumno';

    protected $fillable = [
        'monto', 'alumno_id', 'grado_id', 'mes_id', 'tipo_pago_alumno_id'
    ];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'alumno_id', 'id');
    }
    public function grado()
    {
        return $this->belongsTo(Grado::class, 'grado_id', 'id');
    }
    public function mes()
    {
        return $this->belongsTo(Mes::class, 'mes_id', 'id');
    }
    public function tipo_pago_alumno()
    {
        return $this->belongsTo(TipoPagoAlumno::class, 'tipo_pago_alumno_id', 'id');
    }
}
