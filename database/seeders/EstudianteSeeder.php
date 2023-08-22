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
        $password = '$2y$10$W/vXx3wIgbBmP90OZULJmurA.YODG4uDjelCj4v7SqDtjgiX9a2ey'; // Contraseña común

        for ($i = 1; $i <= 10; $i++) {
            DB::table('usuarios')->insert([
                'nickname' => 'estudiante'.$i,
                'email' => 'estudiante'.$i.'@mail.com',
                'password' => $password,
                'telefono' => '09'.rand(10000000, 99999999),
                'nombre' => 'Estudiante '.$i,
                'biografia' => 'esta es mi biografia',
                'imagen' => 'https://example.com/imagen_estudiante'.$i.'.jpg',
                'status_id' => 2,
                'creditos_number' => 0,
                'type' => 'estudiante',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('estudiantes')->insert([
                'user_id' => $i,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        DB::table('usuarios')->insert([
            'nickname' => 'antonio337',
            'email' => 'antonio@mail.com',
            'password' => $password,
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
            'user_id' => 11,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
