<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $eventosCount = 18; // Cantidad total de cursos/eventos

        for ($i = 1; $i <= $eventosCount; $i++) {
            $numModulos = rand(2, 4); // Generar cantidad aleatoria de módulos

            for ($j = 1; $j <= $numModulos; $j++) {
                DB::table('modulos')->insert([
                    'nombre' => 'Módulo ' . $j . ' - Curso ' . $i,
                    'estado' => 'aprobado',
                    'curso_id' => $i,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
