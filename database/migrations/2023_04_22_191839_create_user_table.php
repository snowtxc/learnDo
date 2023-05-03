<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->increments('id');
            $table->string("nickname")->unique();
            $table->string("email")->unique();
            $table->string("password");
            $table->string("telefono");
            $table->string("nombre");
            $table->string("biografia");
            $table->string("imagen");
            $table->integer("status_id")->unsigned()->nullable();
            $table->integer("creditos_number")->default(0)->nullable();
            $table->string("type")->nullable();
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
        Schema::dropIfExists('usuarios');
    }
}
