<?php

namespace App\Models\escuela\sistema;

use App\Models\escuela\catalogo\Mes;
use App\Models\escuela\sistema\Alumno;
use Illuminate\Database\Eloquent\Model;
use App\Models\escuela\catalogo\GradoSeccion;
use App\Models\escuela\catalogo\TipoPagoAlumno;

class PagoAlumno extends Model
{
    const Proximo = 'Próximo Año';
    const Actual = 'Año Actual';

    const MontoI = 200;
    const MontoM = 100;

    protected $table = 'pago_alumno';

    protected $fillable = [
        'monto', 'alumno_id', 'grado_seccion_id', 'mes_id', 'tipo_pago_alumno_id', 'anio', 'padre_id'
    ];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'alumno_id', 'id');
    }
    public function grado_seccion()
    {
        return $this->belongsTo(GradoSeccion::class, 'grado_seccion_id', 'id');
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
