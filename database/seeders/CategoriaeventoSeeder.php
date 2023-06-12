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
        DB::table('categoriaeventos')->insert([
            'evento_id' => '1',
            'categoria_id' => '1',
            'id' => 1,
        ]);

        DB::table('categoriaeventos')->insert([
            'evento_id' => '2',
            'categoria_id' => '2',
            'id' => 2,
        ]);
    }
}
