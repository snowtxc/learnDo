<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeminarioPresencialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('seminario_presencials')->insert([
            'evento_id' => '3',
            'nombre_ubicacion' => 'Teatro Maccio',
            'latitud' => '-34.33880704024727',
            'longitud' => '-56.7135830944061',
            'fecha' => '30/06/2023',
            'hora' => '14:30',
            'duracion' => '2',
            'maximo_participantes' => '30',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('seminario_presencials')->insert([
            'evento_id' => '5',
            'nombre_ubicacion' => 'Museo Departamental',
            'latitud' => '-34.33781667310125',
            'longitud' => '-56.7143994800415',
            'fecha' => '27/06/2023',
            'hora' => '18:00',
            'duracion' => '1',
            'maximo_participantes' => '100',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('seminario_presencials')->insert([
            'evento_id' => '6',
            'nombre_ubicacion' => 'Club San Jose',
            'latitud' => '-34.33956410856679',
            'longitud' => '-56.713034235645765',
            'fecha' => '18/06/2023',
            'hora' => '21:30',
            'duracion' => '4',
            'maximo_participantes' => '20',
            'created_at' => now(),
            'updated_at' => now(),

        ]);
    }
}
