<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompraEventoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compraevento', function (Blueprint $table) {
            $table->id();
            $table->string('metodoPago');
            $table->double('monto');
            $table->integer('estudiante_id')->unsigned();
            $table->integer("evento_id")->unsigned();
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
        Schema::dropIfExists('compraevento');
    }
}
