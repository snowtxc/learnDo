<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $userStatusSeeder = new UserStatusSeeder();
        $userStatusSeeder->run();

        $estudiantesSeeder = new EstudianteSeeder();
        $estudiantesSeeder->run();

        $categoriasSeeder = new CategoriaSeeder();
        $categoriasSeeder->run();

        $EventoSeeder = new EventoSeeder();
        $EventoSeeder->run();

        $CursoSeeder = new CursoSeeder();
        $CursoSeeder->run();

        $ModuloSeeder = new ModuloSeeder();
        $ModuloSeeder->run();

        $ClaseSeeder = new ClaseSeeder();
        $ClaseSeeder->run();

        $EvaluacionSeeder = new EvaluacionSeeder();
        $EvaluacionSeeder->run();

        $PreguntaSeeder = new PreguntaSeeder();
        $PreguntaSeeder->run();

        $OpcionSeeder = new OpcionSeeder();
        $OpcionSeeder->run();

        $SeminarioPresencialSeeder = new SeminarioPresencialSeeder();
        $SeminarioPresencialSeeder->run();

        $categoriaeventoSeeder = new CategoriaeventoSeeder();
        $categoriaeventoSeeder->run();
    }
}
