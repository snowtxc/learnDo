<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaeventoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $eventos = DB::table('eventos')->select('id')->get();
        $categorias = DB::table('categorias')->select('id')->get();

        foreach ($eventos as $evento) {
            $categoriaAleatoria = $categorias->random();

            DB::table('categoriaeventos')->insert([
                'evento_id' => $evento->id,
                'categoria_id' => $categoriaAleatoria->id,
            ]);
        }
    }
}
