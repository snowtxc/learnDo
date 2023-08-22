<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modulosCount = 53; // Cantidad total de módulos

        for ($i = 1; $i <= $modulosCount; $i++) {
            $numClases = rand(2, 4); // Generar cantidad aleatoria de clases

            for ($j = 1; $j <= $numClases; $j++) {
                DB::table('clases')->insert([
                    'nombre' => 'Clase ' . $j . ' - Módulo ' . $i,
                    'descripcion' => 'Descripción de la Clase ' . $j . ' del Módulo ' . $i,
                    'video' => 'https://player.vimeo.com/video/374410050',
                    'estado' => 'aprobado',
                    'modulo_id' => $i,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}