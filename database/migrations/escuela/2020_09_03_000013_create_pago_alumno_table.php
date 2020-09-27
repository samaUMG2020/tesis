<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagoAlumnoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pago_alumno', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('monto', 11, 2);
            $table->year("anio");
            $table->smallInteger('padre_id')->default(0);

            $table->unsignedBigInteger('alumno_id');
            $table->foreign('alumno_id')->references('id')->on('alumno');

            $table->unsignedBigInteger('grado_seccion_id');
            $table->foreign('grado_seccion_id')->references('id')->on('grado_seccion');

            $table->unsignedBigInteger('mes_id');
            $table->foreign('mes_id')->references('id')->on('mes');

            $table->unsignedBigInteger('tipo_pago_alumno_id');
            $table->foreign('tipo_pago_alumno_id')->references('id')->on('tipo_pago_alumno');
            
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
        Schema::dropIfExists('pago_alumno');
    }
}
