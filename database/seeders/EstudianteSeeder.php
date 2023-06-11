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
            'imagen' => 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8dXNlcnxlbnwwfHwwfHx8MA%3D%3D&w=1000&q=80',
            'status_id' => 2,
            'creditos_number' => 0,
            'type' => 'estudiante',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('estudiantes')->insert([
            'user_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        DB::table('usuarios')->insert([
            'nickname' => 'marto01',
            'email' => 'martin@mail.com',
            'password' => '$2y$10$GwM5aWNpCm0uBxIXgrXmz.odpGUIVHzVqvv8/p0NEQ7SJjctqAWo2',
            'telefono' => '095987237',
            'nombre' => 'Martin Gimenez',
            'biografia' => 'esta es mi biografia',
            'imagen' => 'https://media.istockphoto.com/id/621857498/photo/making-a-decision.jpg?s=612x612&w=0&k=20&c=OJOLnPnnDTCr0pqj1HzYnjC1e9D_vxWTdXco7ppS9Ig=',
            'status_id' => '2',
            'creditos_number' => 0,
            'type' => 'estudiante',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('estudiantes')->insert([
            'user_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('usuarios')->insert([
            'nickname' => 'Carlitos24',
            'email' => 'carlito@mail.com',
            'password' => '$2y$10$GwM5aWNpCm0uBxIXgrXmz.odpGUIVHzVqvv8/p0NEQ7SJjctqAWo2',
            'telefono' => '095987345',
            'nombre' => 'Carlos Gonsalez',
            'biografia' => 'esta es mi biografia',
            'imagen' => 'https://media.istockphoto.com/id/621857498/photo/making-a-decision.jpg?s=612x612&w=0&k=20&c=OJOLnPnnDTCr0pqj1HzYnjC1e9D_vxWTdXco7ppS9Ig=',
            'status_id' => '2',
            'creditos_number' => 0,
            'type' => 'estudiante',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('estudiantes')->insert([
            'user_id' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        DB::table('usuarios')->insert([
            'nickname' => 'antonio337',
            'email' => 'antonio@mail.com',
            'password' => '$2y$10$GwM5aWNpCm0uBxIXgrXmz.odpGUIVHzVqvv8/p0NEQ7SJjctqAWo2',
            'telefono' => '096321548',
            'nombre' => 'Antonio Perez',
            'biografia' => 'esta es mi biografia',
            'imagen' => 'https://t4.ftcdn.net/jpg/01/30/38/97/360_F_130389777_uiT2Kfcp3nQ4arvbabaeDu3UDp6khzTR.jpg',
            'status_id' => '2',
            'creditos_number' => 0,
            'type' => 'organizador',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('organizadors')->insert([
            'user_id' => 4,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
