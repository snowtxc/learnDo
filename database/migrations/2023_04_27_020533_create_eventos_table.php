<?php

use App\Models\Categoria;
use App\Models\Organizador;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->increments('id');
            $table->string("nombre");
            $table->string("descripcion");
            $table->string("imagen")->default("https://xegmenta.com/wp-content/uploads/2019/06/organizar-evento-corp-opt.jpg");
            $table->boolean('es_pago')->default(0);
            $table->integer("precio")->default(null)->nullable();
            $table->float('ganancias_acumuladas')->default(0);
            $table->integer("organizador_id")->unsigned()->nullable();
            $table->string("tipo");
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
        Schema::dropIfExists('eventos');
    }
}
