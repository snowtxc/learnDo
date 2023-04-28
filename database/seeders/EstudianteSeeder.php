<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstudianteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('usuarios')->insert([
            'id' => 1,
            'nickname' => 'pepe',
            'email' => 'pepe@mail.com',
            'password' => 'asdasd',
            'telefono' => '098365963',
            'nombre' => 'Pepe Gonzales',
            'biografia' => 'esta es mi biografia',
            'imagen' => 'img1',
            'status_id' => 2,
            'creditos_number' => 0,
            'type' => 'App\Models\Estudiante',
            // 'created_at' => '2023-04-25',
            // 'uploaded_at' => '2023-04-25',
        ]);
        
        DB::table('usuarios')->insert([
            'id' => 2,
            'nickname' => 'marto01',
            'email' => 'martin@mail.com',
            'password' => 'asdasd',
            'telefono' => '095987237',
            'nombre' => 'Martin Gimenez',
            'biografia' => 'esta es mi biografia',
            'imagen' => 'img2',
            'status_id' => '2',
            'creditos_number' => 0,
            'type' => 'App\Models\Estudiante',
            // 'created_at' => '2023-04-25',
            // 'uploaded_at' => '2023-04-25',
        ]);
        
        DB::table('usuarios')->insert([
            'id' => 3,
            'nickname' => 'antonio337',
            'email' => 'antonio@mail.com',
            'password' => 'assaaxccxzc',
            'telefono' => '096321548',
            'nombre' => 'Antonio Perez',
            'biografia' => 'esta es mi biografia',
            'imagen' => 'img3',
            'status_id' => '2',
            'creditos_number' => 0,
            'type' => 'App\Models\Organizador',
            // 'created_at' => '2023-04-25',
            // 'uploaded_at' => '2023-04-25',
        ]);
        
        
    }
}
