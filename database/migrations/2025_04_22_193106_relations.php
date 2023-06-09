<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Relations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::table('usuarios', function (Blueprint $table) {
            $table->foreign('status_id')
                ->references('id')
                ->on('user_statuses');
        });
        Schema::table('estudiantes', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')
                ->on('usuarios')
                ->onDelete('cascade');
        });
        Schema::table('organizadors', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')
                ->on('usuarios')
                ->onDelete('cascade');
        });
        Schema::table('seminario_virtuals', function (Blueprint $table) {
            $table->foreign('evento_id')
                ->references('id')
                ->on('eventos')
                ->onDelete("cascade");
        });
        Schema::table('seminario_presencials', function (Blueprint $table) {
            $table->foreign('evento_id')
                ->references('id')
                ->on('eventos')
                ->onDelete("cascade");
        });
        Schema::table('cursos', function (Blueprint $table) {
            $table->foreign('evento_id_of_curso')
                ->references('id')
                ->on('eventos')
                ->onDelete('cascade');

        });
        Schema::table('mensajes', function (Blueprint $table) {
            $table->foreign('user_from_id')
                ->references('id')
                ->on('usuarios')
                ->onDelete('cascade');

        });
        Schema::table('mensajes', function (Blueprint $table) {
            $table->foreign('user_to_id')
                ->references('id')
                ->on('usuarios')
                ->onDelete('cascade');

        });
        Schema::table('mensaje_salas', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')
                ->on('usuarios')
                ->onDelete('cascade');


        });
        Schema::table('mensaje_salas', function (Blueprint $table) {
            $table->foreign('seminario_virtual_id')
                ->references('evento_id')
                ->on('seminario_virtuals')
                ->onDelete('cascade');

        });
        Schema::table('publicacions', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')
                ->on('usuarios')
                ->onDelete('cascade');

        });
        Schema::table('comentarios', function (Blueprint $table) {
            $table->foreign('publicacion_id')
                ->references('id')
                ->on('publicacions')->onDelete('cascade');
        });
        Schema::table('comentarios', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')
                ->on('usuarios')
                ->onDelete('cascade');

                
        });
        Schema::table('publicacions', function (Blueprint $table) {
            $table->foreign('foro_id')
                ->references('id')
                ->on('foros')
                ->onDelete('cascade');

        });
        Schema::table('calificacions', function (Blueprint $table) {
            $table->foreign('estudiante_id')
                ->references('user_id')
                ->on('estudiantes')
                ->onDelete('cascade');

        });
        Schema::table('calificacions', function (Blueprint $table) {
            $table->foreign('evaluacion_id')
                ->references('id')
                ->on('evaluacions')
                ->onDelete('cascade');

        });
        Schema::table('preguntas', function (Blueprint $table) {
            $table->foreign('evaluacion_id')
                ->references('id')
                ->on('evaluacions')
                ->onDelete('cascade');

        });
        Schema::table('opcions', function (Blueprint $table) {
            $table->foreign('pregunta_id')
                ->references('id')
                ->on('preguntas')
                ->onDelete('cascade');

        });
        Schema::table('evaluacions', function (Blueprint $table) {
            $table->foreign('modulo_id')
                ->references('id')
                ->on('modulos')
                ->onDelete('cascade');

        });
        Schema::table('clases', function (Blueprint $table) {
            $table->foreign('modulo_id')
                ->references('id')
                ->on('modulos')
                ->onDelete('cascade');

            $table->foreign('sugerencia_id')
                ->references('id')
                ->on('sugerencias')
                ->onDelete('cascade');

        });
        Schema::table('modulos', function (Blueprint $table) {
            $table->foreign('curso_id')
                ->references('evento_id_of_curso')
                ->on('cursos')
                ->onDelete('cascade');

            $table->foreign('sugerencia_id')
                ->references('id')
                ->on('sugerencias')
                ->onDelete('cascade');

        });

        Schema::table('foros', function (Blueprint $table) {
            $table->foreign('id_curso')
                ->references('evento_id_of_curso')
                ->on('cursos')
                ->onDelete('cascade');

        });

        Schema::table('certificados', function (Blueprint $table) {
            $table->foreign('curso_id')
                ->references('evento_id_of_curso')
                ->on('cursos')
                ->onDelete('cascade');


         $table->foreign('estudiante_id')
                ->references('user_id')
                ->on('estudiantes')
                ->onDelete('cascade');

        });

       
        Schema::table('puntuacions', function (Blueprint $table) {
            $table->foreign('estudiante_id')
                ->references('user_id')
                ->on('estudiantes')
                ->onDelete('cascade');

        });

        Schema::table('puntuacions', function (Blueprint $table) {
            $table->foreign('curso_id')
                ->references('evento_id_of_curso')
                ->on('cursos')
                ->onDelete('cascade');

        });

        Schema::table('sugerencias', function (Blueprint $table) {
            $table->foreign('curso_id')
                ->references('evento_id_of_curso')
                ->on('cursos')
                ->onDelete('cascade');

        });

        Schema::table('sugerencias', function (Blueprint $table) {
            $table->foreign('estudiante_id')
                ->references('user_id')
                ->on('estudiantes')
                ->onDelete('cascade');

        });

        Schema::table('eventos', function (Blueprint $table) {
            $table->foreign('organizador_id')
                ->references('user_id')
                ->on('organizadors')
                ->onDelete('cascade');

        });

        Schema::table('categoriaeventos', function (Blueprint $table) {
            $table->foreign('categoria_id')
                ->references('id')
                ->on('categorias')
                ->onDelete('cascade');

        });

        Schema::table('categoriaeventos', function (Blueprint $table) {
            $table->foreign('evento_id')
                ->references('id')
                ->on('eventos')
                ->onDelete('cascade');

        });

        Schema::table('colaboracions', function (Blueprint $table) {
            $table->foreign('evento_id')
                ->references('id')
                ->on('eventos')
                ->onDelete('cascade');

        });

        Schema::table('colaboracions', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')
                ->on('usuarios')
                ->onDelete('cascade');

        });

        Schema::table('cupons', function (Blueprint $table) {
            $table->foreign('user_id_from')
                ->references('id')
                ->on('usuarios')
                ->onDelete('cascade');

        });

        Schema::table('compraevento', function (Blueprint $table) {
            $table->foreign('evento_id')
                ->references('id')
                ->on('eventos');
            $table->foreign('estudiante_id')
            ->references('user_id')
            ->on('estudiantes')
            ->onDelete('cascade');

        });

        Schema::enableForeignKeyConstraints();
    }

    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
