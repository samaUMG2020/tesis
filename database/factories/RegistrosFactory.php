<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Models\escuela\sistema\Alumno;
use App\Models\escuela\sistema\Persona;
use App\Models\escuela\catalogo\Municipio;
use App\Models\escuela\sistema\Catedratico;

$factory->define(Alumno::class, function (Faker $faker) {
    $persona = new Persona();
    do {
        $persona->nombre = $faker->firstName;
        $persona->apellido = $faker->lastName;
    } while(!is_null(Persona::where('nombre', $faker->firstName)->where('apellido', $faker->lastName)->first()));
    $persona->email = $faker->email;
    $persona->fecha_nacimiento = $faker->date('Y-m-d', date("Y-m-d", strtotime(date('Y-m-d') . "- 12 year")));
    $persona->municipio_id = Municipio::all()->random()->id;
    $persona->save();

    return [
        'codigo' => $faker->unique()->numberBetween(1000, 99999),
        'nombre_completo' => "{$persona->nombre} {$persona->apellido}",
        'persona_id' => $persona->id,
        'activo' => true,
        'graduado' => false,
        'fin_ciclo' => true
    ];
});

$factory->define(Catedratico::class, function (Faker $faker) {
    $persona = new Persona();
    do {
        $persona->nombre = $faker->firstName;
        $persona->apellido = $faker->lastName;
    } while (!is_null(Persona::where('nombre', $faker->firstName)->where('apellido', $faker->lastName)->first()));
    $persona->email = $faker->email;
    $persona->fecha_nacimiento = $faker->date('Y-m-d', date("Y-m-d", strtotime(date('Y-m-d') . "- 12 year")));
    $persona->municipio_id = Municipio::all()->random()->id;
    $persona->save();

    return [
        'codigo' => $faker->unique()->numberBetween(1000, 99999),
        'nombre_completo' => "{$persona->nombre} {$persona->apellido}",
        'persona_id' => $persona->id,
        'activo' => true
    ];
});
