<?php

namespace App\Models\escuela\sistema;

use App\Models\escuela\catalogo\Mes;
use Illuminate\Database\Eloquent\Model;

class PagoCatedratico extends Model
{
    protected $table = 'pago_catedratico';

    protected $fillable = [
        'monto', 'anio', 'catedratico_id', 'mes_id'
    ];

    
    public function catedratico()
    {
        return $this->belongsTo(Catedratico::class, 'catedratico_id', 'id');
    }
    public function mes()
    {
        return $this->belongsTo(Mes::class, 'mes_id', 'id');
    }
    
    
}
