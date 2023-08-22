<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PreguntaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $evaluaciones = DB::table('evaluacions')->pluck('id');

        foreach ($evaluaciones as $evaluacionId) {
            $numPreguntas = rand(5, 7); // Genera un número aleatorio entre 5 y 7

            for ($i = 1; $i <= $numPreguntas; $i++) {
                DB::table('preguntas')->insert([
                    'contenido' => 'Pregunta ' . $i,
                    'evaluacion_id' => $evaluacionId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
