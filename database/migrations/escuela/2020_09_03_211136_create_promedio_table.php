<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromedioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promedio', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('promedio', 5, 2);
            $table->year('anio');
            $table->integer("bimestres");

            $table->unsignedBigInteger('alumno_grado_id');
            $table->foreign('alumno_grado_id')->references('id')->on('alumno_grado'); 

            $table->unsignedBigInteger('curso_id');
            $table->foreign('curso_id')->references('id')->on('curso'); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promedio');
    }
}
