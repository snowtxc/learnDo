<?php

namespace Database\Seeders;

use App\Models\Estudiante;
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
            'nickname' => 'pepe',
            'email' => 'pepe@mail.com',
            'password' => '$2y$10$GwM5aWNpCm0uBxIXgrXmz.odpGUIVHzVqvv8/p0NEQ7SJjctqAWo2',
            'telefono' => '098365963',
            'nombre' => 'Pepe Gonzales',
            'biografia' => 'esta es mi biografia',
            'imagen' => 'img1',
            'status_id' => 2,
            'creditos_number' => 0,
            'type' => 'estudiante',
        ]);
        DB::table('estudiantes')->insert([
            'user_id' => 1,
        ]);
        
        DB::table('usuarios')->insert([
            'nickname' => 'marto01',
            'email' => 'martin@mail.com',
            'password' => '$2y$10$GwM5aWNpCm0uBxIXgrXmz.odpGUIVHzVqvv8/p0NEQ7SJjctqAWo2',
            'telefono' => '095987237',
            'nombre' => 'Martin Gimenez',
            'biografia' => 'esta es mi biografia',
            'imagen' => 'img2',
            'status_id' => '2',
            'creditos_number' => 0,
            'type' => 'estudiante',
        ]);
        DB::table('estudiantes')->insert([
            'user_id' => 2,
        ]);
        
        DB::table('usuarios')->insert([
            'nickname' => 'antonio337',
            'email' => 'antonio@mail.com',
            'password' => '$2y$10$GwM5aWNpCm0uBxIXgrXmz.odpGUIVHzVqvv8/p0NEQ7SJjctqAWo2',
            'telefono' => '096321548',
            'nombre' => 'Antonio Perez',
            'biografia' => 'esta es mi biografia',
            'imagen' => 'img3',
            'status_id' => '2',
            'creditos_number' => 0,
            'type' => 'organizador',
        ]);
        DB::table('organizadors')->insert([
            'user_id' => 3,
        ]);
    }
}
