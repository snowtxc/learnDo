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
        for ($i = 1; $i <= 18; $i++) {
            DB::table('cursos')->insert([
                'evento_id_of_curso' => $i,
                'porcentaje_aprobacion' => rand(50, 80),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
