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
            'nombre' => 'Programación',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('categorias')->insert([
            'nombre' => 'Cocina',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('categorias')->insert([
            'nombre' => 'Economía',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('categorias')->insert([
            'nombre' => 'Autos',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('categorias')->insert([
            'nombre' => 'Tecnología',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('categorias')->insert([
            'nombre' => 'Salud',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('categorias')->insert([
            'nombre' => 'Educación',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('categorias')->insert([
            'nombre' => 'Arte y Cultura',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('categorias')->insert([
            'nombre' => 'Deportes',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('categorias')->insert([
            'nombre' => 'Ciencia',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('categorias')->insert([
            'nombre' => 'Viajes',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('categorias')->insert([
            'nombre' => 'Negocios',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('categorias')->insert([
            'nombre' => 'Medio Ambiente',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('categorias')->insert([
            'nombre' => 'Moda',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('categorias')->insert([
            'nombre' => 'Literatura',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
