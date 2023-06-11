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
        DB::table('modulos')->insert([
            'id' => '1',
            'nombre' => 'Conceptos Basicos de php',
            'estado' => 'null',
            'curso_id' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('modulos')->insert([
            'id' => '2',
            'nombre' => 'Conceptos Medios de php',
            'estado' => 'null',
            'curso_id' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('modulos')->insert([
            'id' => '3',
            'nombre' => 'Conceptos Avanzados de php',
            'estado' => 'null',
            'curso_id' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('modulos')->insert([
            'id' => '4',
            'nombre' => 'Como utilizar las diferentes herramientas de la cocina',
            'estado' => 'null',
            'curso_id' => '2',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('modulos')->insert([
            'id' => '5',
            'nombre' => 'Ingredientes principales y como se utilizan',
            'estado' => 'null',
            'curso_id' => '2',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('modulos')->insert([
            'id' => '6',
            'nombre' => 'Recetas y platos',
            'estado' => 'null',
            'curso_id' => '2',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
