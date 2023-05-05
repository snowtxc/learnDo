<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMensajeSalasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mensaje_salas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('conenido');
            $table->date('fecha_emision');
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('seminario_virtual_id')->unsigned()->nullable();
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
        Schema::dropIfExists('mensaje_salas');
    }
}
