<?php

use App\Imports\CarreraImport;
use Illuminate\Database\Seeder;
use App\Imports\MunicipioImport;
use App\Imports\DepartamentoImport;
use App\Models\escuela\seguridad\Rol;
use App\Models\escuela\sistema\Persona;
use App\Models\escuela\catalogo\Carrera;
use App\Models\escuela\catalogo\Seccion;
use App\Models\escuela\catalogo\Bimestre;
use App\Models\escuela\catalogo\Curso;
use App\Models\escuela\seguridad\Usuario;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \Excel::import(new DepartamentoImport, 'database/excel/Departamentos.xlsx');
        \Excel::import(new MunicipioImport, 'database/excel/Municipios.xlsx');
        \Excel::import(new CarreraImport, 'database/excel/Carreras.xlsx');

        $bimestre = new Bimestre();
        $bimestre->nombre = "Primer bimestre";
        $bimestre->save();

        $bimestre = new Bimestre();
        $bimestre->nombre = "Segundo bimestre";
        $bimestre->save();

        $bimestre = new Bimestre();
        $bimestre->nombre = "Tercer bimestre";
        $bimestre->save();

        $bimestre = new Bimestre();
        $bimestre->nombre = "Cuarto bimestre";
        $bimestre->save();

        $seccion = new Seccion();
        $seccion->nombre = "A";
        $seccion->save();

        $seccion = new Seccion();
        $seccion->nombre = "B";
        $seccion->save();

        $seccion = new Seccion();
        $seccion->nombre = "C";
        $seccion->save();

        $seccion = new Seccion();
        $seccion->nombre = "D";
        $seccion->save();

        $curso = new Curso();
        $curso->nombre = "Matemática";
        $curso->save();

        $curso = new Curso();
        $curso->nombre = "Idioma Español";
        $curso->save();

        $rol_administrador = new Rol();
        $rol_administrador->nombre = "administrador";
        $rol_administrador->save();

        $rol_director = new Rol();
        $rol_director->nombre = "director";
        $rol_director->save();

        $rol_secretaria = new Rol();
        $rol_secretaria->nombre = "secretaria";
        $rol_secretaria->save();

        $rol_catedratico = new Rol();
        $rol_catedratico->nombre = "catedrático";
        $rol_catedratico->save();

        $persona = new Persona();
        $persona->nombre = 'samanda';
        $persona->apellido = 'hernández';
        $persona->email = 'administrador@escuela.com';
        $persona->fecha_nacimiento = '1993-01-01';
        $persona->telelfono = '58545854';
        $persona->municipio_id = 1;
        $persona->save();

        $usuario = new Usuario();
        $usuario->nombre_completo = "{$persona->nombre} {$persona->apellido}";
        $usuario->email = $persona->email;
        $usuario->password = "secret";
        $usuario->persona_id = $persona->id;
        $usuario->rol_id = $rol_administrador->id;
        $usuario->save();

        $persona = new Persona();
        $persona->nombre = 'director';
        $persona->apellido = 'hernández';
        $persona->email = 'director@escuela.com';
        $persona->fecha_nacimiento = '1993-01-01';
        $persona->telelfono = '58545854';
        $persona->municipio_id = 1;
        $persona->save();

        $usuario = new Usuario();
        $usuario->nombre_completo = "{$persona->nombre} {$persona->apellido}";
        $usuario->email = $persona->email;
        $usuario->password = "secret";
        $usuario->persona_id = $persona->id;
        $usuario->rol_id = $rol_director->id;
        $usuario->save();

        $persona = new Persona();
        $persona->nombre = 'secretaria';
        $persona->apellido = 'hernández';
        $persona->email = 'secretaria@escuela.com';
        $persona->fecha_nacimiento = '1993-01-01';
        $persona->telelfono = '58545854';
        $persona->municipio_id = 1;
        $persona->save();

        $usuario = new Usuario();
        $usuario->nombre_completo = "{$persona->nombre} {$persona->apellido}";
        $usuario->email = $persona->email;
        $usuario->password = "secret";
        $usuario->persona_id = $persona->id;
        $usuario->rol_id = $rol_secretaria->id;
        $usuario->save();

        $persona = new Persona();
        $persona->nombre = 'catedrático';
        $persona->apellido = 'hernández';
        $persona->email = 'catedratico@escuela.com';
        $persona->fecha_nacimiento = '1993-01-01';
        $persona->telelfono = '58545854';
        $persona->municipio_id = 1;
        $persona->save();

        $usuario = new Usuario();
        $usuario->nombre_completo = "{$persona->nombre} {$persona->apellido}";
        $usuario->email = $persona->email;
        $usuario->password = "secret";
        $usuario->persona_id = $persona->id;
        $usuario->rol_id = $rol_catedratico->id;
        $usuario->save();
    }
}
