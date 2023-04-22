<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_statuses')->insert([
            'id' => 1,
            'nombre' => 'Pending',
        ]);
        DB::table('user_statuses')->insert([
            'id' => 2,
            'nombre' => 'Active',
        ]);
    }
}
