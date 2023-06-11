<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CursoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cursos')->insert([
            'evento_id_of_curso' => '1',
            'porcentaje_aprobacion' => '60',
            'ganancias_acumuladas' => '0',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('cursos')->insert([
            'evento_id_of_curso' => '2',
            'porcentaje_aprobacion' => '70',
            'ganancias_acumuladas' => '0',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
