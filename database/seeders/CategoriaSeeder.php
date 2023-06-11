<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categorias')->insert([
            'id' => 1,
            'nombre' => 'Programacion',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('categorias')->insert([
            'id' => 2,
            'nombre' => 'Cocina',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('categorias')->insert([
            'id' => 3,
            'nombre' => 'Economia',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('categorias')->insert([
            'id' => 4,
            'nombre' => 'Autos',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('categorias')->insert([
            'id' => 5,
            'nombre' => 'Algo',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('categorias')->insert([
            'id' => 6,
            'nombre' => 'Nuevo Algo',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('categorias')->insert([
            'id' => 7,
            'nombre' => 'EstaCategoria',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('categorias')->insert([
            'id' => 8,
            'nombre' => 'Arquitectura',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
