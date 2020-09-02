<?php

namespace App\Imports;

use App\Models\escuela\catalogo\Departamento;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class DepartamentoImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $key => $value) {
            if(!is_null($value[0])) {
                $nuevo = new Departamento();
                $nuevo->nombre = $value[0];
                $nuevo->save();
            }
        }
    }
}
