<?php

namespace App\Models\escuela\catalogo;

use App\Models\escuela\sistema\PagoCatedratico;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Mes extends Model
{
    use SearchableTrait;

    const NA = '13';

    protected $searchable = [
        'columns' => [
            'mes.nombre' => 10,
        ]
    ];

    protected $table = 'mes';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'nombre'
    ];

    public function pagos_catedraticos()
    {
        return $this->hasMany(PagoCatedratico::class, 'mes_id', 'id');
    }
}