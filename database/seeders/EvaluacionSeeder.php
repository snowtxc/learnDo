<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EvaluacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 53; $i++) {
            DB::table('evaluacions')->insert([
                'nombre' => 'Evaluacion Módulo ' . $i,
                'modulo_id' => $i,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
