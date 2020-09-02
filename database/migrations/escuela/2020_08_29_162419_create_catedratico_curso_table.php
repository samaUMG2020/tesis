<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatedraticoCursoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catedratico_curso', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('curso_g_s_id');
            $table->foreign('curso_g_s_id')->references('id')->on('curso_g_s');

            $table->unsignedBigInteger('catedratico_id');
            $table->foreign('catedratico_id')->references('id')->on('catedratico');            

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
        Schema::dropIfExists('catedratico_curso');
    }
}
