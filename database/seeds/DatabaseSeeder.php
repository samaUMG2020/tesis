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
use App\Models\escuela\catalogo\CursoGS;
use App\Models\escuela\catalogo\Grado;
use App\Models\escuela\catalogo\GradoSeccion;
use App\Models\escuela\catalogo\Mes;
use App\Models\escuela\catalogo\TipoFondo;
use App\Models\escuela\catalogo\TipoPagoAlumno;
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

        $carrera = new Carrera();
        $carrera->nombre = 'Básico';
        $carrera->save();

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

        $mes = new Mes();
        $mes->nombre = "Enero";
        $mes->save();

        $mes = new Mes();
        $mes->nombre = "Febrero";
        $mes->save();

        $mes = new Mes();
        $mes->nombre = "Marzo";
        $mes->save();

        $mes = new Mes();
        $mes->nombre = "Abril";
        $mes->save();

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

        $curso = new Curso();
        $curso->nombre = "Idioma Inglés";
        $curso->save();

        $curso = new Curso();
        $curso->nombre = "Ciencias Sociales";
        $curso->save();

        $carreras = Carrera::all();

        foreach ($carreras as $key => $value) {
            $grado = new Grado();
            $grado->nombre = 'Primero';
            $grado->nombre_completo = "{$value->nombre} {$grado->nombre}";
            $grado->carrera_id = $value->id;
            $grado->save();

            $grado = new Grado();
            $grado->nombre = 'Segundo';
            $grado->nombre_completo = "{$value->nombre} {$grado->nombre}";
            $grado->carrera_id = $value->id;
            $grado->save();

            $grado = new Grado();
            $grado->nombre = 'Tercero';
            $grado->nombre_completo = "{$value->nombre} {$grado->nombre}";
            $grado->carrera_id = $value->id;
            $grado->save();
        }

        $grados = Grado::all();

        foreach ($grados as $value) {

            $secciones = Seccion::all();

            foreach ($secciones as $value_uno) {
                $grado_seccion = new GradoSeccion();
                $grado_seccion->seccion_id = $value_uno->id;
                $grado_seccion->grado_id = $value->id;
                $grado_seccion->nombre_completo = "{$value->nombre_completo} {$value_uno->nombre}";
                $grado_seccion->save();
            }
        }

        $grados_secciones = GradoSeccion::all();

        foreach ($grados_secciones as $value) {

            $cursos = Curso::all();

            foreach ($cursos as $value_uno) {
                $curso_gs = new CursoGS();
                $curso_gs->curso_id = $value_uno->id;
                $curso_gs->grado_seccion_id = $value->id;
                $curso_gs->nombre_completo = "{$value->nombre_completo} {$value_uno->nombre}";
                $curso_gs->save();
            }
        }

        $tipo_fondo = new TipoFondo();
        $tipo_fondo->nombre = "Estatal";
        $tipo_fondo->save();

        $tipo_fondo = new TipoFondo();
        $tipo_fondo->nombre = "Municipal";
        $tipo_fondo->save();

        $tipo_pago_alumno = new TipoPagoAlumno();
        $tipo_pago_alumno->nombre = "Inscripción";
        $tipo_pago_alumno->save();

        $tipo_pago_alumno = new TipoPagoAlumno();
        $tipo_pago_alumno->nombre = "Colegiatura";
        $tipo_pago_alumno->save();

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
        $persona->telefono = '58545854';
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
        $persona->telefono = '58545854';
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
        $persona->telefono = '58545854';
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
        $persona->telefono = '58545854';
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
