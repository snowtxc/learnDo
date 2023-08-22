<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OpcionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $preguntas = DB::table('preguntas')->pluck('id');

        foreach ($preguntas as $preguntaId) {
            DB::table('opcions')->insert([
                'contenido' => 'Esta es la opción 1',
                'es_correcta' => '1', // Marca la primera opción como correcta
                'pregunta_id' => $preguntaId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            for ($i = 2; $i <= 4; $i++) {
                DB::table('opcions')->insert([
                    'contenido' => 'Esta es la opción ' . $i,
                    'es_correcta' => '0',
                    'pregunta_id' => $preguntaId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
