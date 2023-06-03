<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCuponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cupons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('token');
            $table->float('descuento');
            $table->date('fecha_vencimiento');
            $table->integer('user_id_from')->unsigned()->nullable();
            $table->integer('evento_id')->unsigned()->nullable();
            $table->boolean('activo')->nullable();
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
        Schema::dropIfExists('cupons');
    }
}
