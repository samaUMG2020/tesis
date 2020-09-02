<?php

namespace App\Imports;

use App\Models\escuela\catalogo\Carrera;
use App\Models\escuela\catalogo\Grado;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class CarreraImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $key => $value) {
            if (!is_null($value[0])) {
                $carrera = new Carrera();
                $carrera->nombre = $value[0];
                $carrera->save();
                
                switch ($value[1]) {
                    case 2:
                        $insert = new Grado();
                        $insert->nombre = 'Cuarto';
                        $insert->nombre_completo = "{$carrera->nombre} - {$insert->nombre}";
                        $insert->carrera_id = $carrera->id;
                        $insert->save();

                        $insert = new Grado();
                        $insert->nombre = 'Quinto';
                        $insert->nombre_completo = "{$carrera->nombre} - {$insert->nombre}";
                        $insert->carrera_id = $carrera->id;
                        $insert->save();
                        break;

                    case 3:
                        $insert = new Grado();
                        $insert->nombre = 'Cuarto';
                        $insert->nombre_completo = "{$carrera->nombre} - {$insert->nombre}";
                        $insert->carrera_id = $carrera->id;
                        $insert->save();

                        $insert = new Grado();
                        $insert->nombre = 'Quinto';
                        $insert->nombre_completo = "{$carrera->nombre} - {$insert->nombre}";
                        $insert->carrera_id = $carrera->id;
                        $insert->save();

                        $insert = new Grado();
                        $insert->nombre = 'Sexto';
                        $insert->nombre_completo = "{$carrera->nombre} - {$insert->nombre}";
                        $insert->carrera_id = $carrera->id;
                        $insert->save();
                        break;
                }
            }
        }
    }
}
