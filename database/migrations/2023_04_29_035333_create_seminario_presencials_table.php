<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeminarioPresencialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seminario_presencials', function (Blueprint $table) {
            $table->integer('evento_id')->unsigned()->nullable();
            $table->string('nombre_ubicacion');
            $table->string('latitud');
            $table->string('longitud');
            $table->integer('maximo_participantes');
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
        Schema::dropIfExists('seminario_presencials');
    }
}
