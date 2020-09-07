<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagoCatedraticoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pago_catedratico', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal("monto", 11, 2);
            $table->year("anio");

            $table->unsignedBigInteger('catedratico_id');
            $table->foreign('catedratico_id')->references('id')->on('catedratico'); 

            $table->unsignedBigInteger('mes_id');
            $table->foreign('mes_id')->references('id')->on('mes');

        
            
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
        Schema::dropIfExists('pago_catedratico');
    }
}
