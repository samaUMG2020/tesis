<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal("nota", 5,2);
            $table->year("anio");

            $table->unsignedBigInteger('alumno_grado_id');
            $table->foreign('alumno_grado_id')->references('id')->on('alumno_grado');

            $table->unsignedBigInteger('curso_id');
            $table->foreign('curso_id')->references('id')->on('curso');

            $table->unsignedBigInteger('bimestre_id');
            $table->foreign('bimestre_id')->references('id')->on('bimestre');

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
        Schema::dropIfExists('notas');
    }
}
