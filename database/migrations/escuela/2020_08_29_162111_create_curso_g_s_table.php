<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCursoGSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curso_g_s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre_completo', 100)->unique();

            $table->unsignedBigInteger('grado_seccion_id');
            $table->foreign('grado_seccion_id')->references('id')->on('grado_seccion');

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
        Schema::dropIfExists('curso_g_s');
    }
}
