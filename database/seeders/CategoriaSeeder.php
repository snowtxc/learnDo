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
        ]);
        DB::table('categorias')->insert([
            'id' => 2,
            'nombre' => 'Cocina',
        ]);
        DB::table('categorias')->insert([
            'id' => 3,
            'nombre' => 'Economia',
        ]);
        DB::table('categorias')->insert([
            'id' => 4,
            'nombre' => 'Autos',
        ]);
        DB::table('categorias')->insert([
            'id' => 5,
            'nombre' => 'Algo',
        ]);
        DB::table('categorias')->insert([
            'id' => 6,
            'nombre' => 'Nuevo Algo',
        ]);
        DB::table('categorias')->insert([
            'id' => 7,
            'nombre' => 'EstaCategoria',
        ]);
        DB::table('categorias')->insert([
            'id' => 8,
            'nombre' => 'Arquitectura',
        ]);
    }
}
