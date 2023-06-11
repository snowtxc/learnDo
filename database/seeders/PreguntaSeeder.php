<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PreguntaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('preguntas')->insert([
            'contenido' => 'Pregunta 1',
            'evaluacion_id' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('preguntas')->insert([
            'contenido' => 'Pregunta 2',
            'evaluacion_id' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('preguntas')->insert([
            'contenido' => 'Pregunta 1',
            'evaluacion_id' => '2',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('preguntas')->insert([
            'contenido' => 'Pregunta 2',
            'evaluacion_id' => '2',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('preguntas')->insert([
            'contenido' => 'Pregunta 1',
            'evaluacion_id' => '3',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('preguntas')->insert([
            'contenido' => 'Pregunta 2',
            'evaluacion_id' => '3',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('preguntas')->insert([
            'contenido' => 'Pregunta 1',
            'evaluacion_id' => '4',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('preguntas')->insert([
            'contenido' => 'Pregunta 2',
            'evaluacion_id' => '4',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('preguntas')->insert([
            'contenido' => 'Pregunta 1',
            'evaluacion_id' => '5',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('preguntas')->insert([
            'contenido' => 'Pregunta 2',
            'evaluacion_id' => '5',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('preguntas')->insert([
            'contenido' => 'Pregunta 1',
            'evaluacion_id' => '6',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('preguntas')->insert([
            'contenido' => 'Pregunta 2',
            'evaluacion_id' => '6',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
