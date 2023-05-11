<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeminarioVirtualsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seminario_virtuals', function (Blueprint $table) {
            $table->integer('evento_id')->unsigned()->nullable();
            $table->string('nombre_plataforma');
            $table->boolean('estado'); // live or not
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
        Schema::dropIfExists('seminario_virtuals');
    }
}
