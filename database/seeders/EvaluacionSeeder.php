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
        DB::table('evaluacions')->insert([
            'nombre' => 'Evaluacion Modulo 1',
            'modulo_id' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('evaluacions')->insert([
            'nombre' => 'Evaluacion Modulo 2',
            'modulo_id' => '2',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('evaluacions')->insert([
            'nombre' => 'Evaluacion Modulo 3',
            'modulo_id' => '3',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('evaluacions')->insert([
            'nombre' => 'Evaluacion Modulo 1',
            'modulo_id' => '4',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('evaluacions')->insert([
            'nombre' => 'Evaluacion Modulo 2',
            'modulo_id' => '5',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('evaluacions')->insert([
            'nombre' => 'Evaluacion Modulo 3',
            'modulo_id' => '6',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
