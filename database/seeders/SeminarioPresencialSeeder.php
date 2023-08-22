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
            'evento_id' => '16',
            'nombre_ubicacion' => 'Teatro Maccio',
            'latitud' => '-34.33880704024727',
            'longitud' => '-56.7135830944061',
            'fecha' => '23/08/2023',
            'hora' => '14:30',
            'duracion' => '2',
            'maximo_participantes' => '30',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('seminario_presencials')->insert([
            'evento_id' => '17',
            'nombre_ubicacion' => 'Museo Departamental',
            'latitud' => '-34.33781667310125',
            'longitud' => '-56.7143994800415',
            'fecha' => '27/08/2023',
            'hora' => '18:00',
            'duracion' => '1',
            'maximo_participantes' => '100',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('seminario_presencials')->insert([
            'evento_id' => '18',
            'nombre_ubicacion' => 'Club San Jose',
            'latitud' => '-34.33956410856679',
            'longitud' => '-56.713034235645765',
            'fecha' => '28/08/2023',
            'hora' => '21:30',
            'duracion' => '4',
            'maximo_participantes' => '20',
            'created_at' => now(),
            'updated_at' => now(),

        ]);

        DB::table('seminario_presencials')->insert([
            'evento_id' => '19',
            'nombre_ubicacion' => 'Teatro Maccio',
            'latitud' => '-34.33880704024727',
            'longitud' => '-56.7135830944061',
            'fecha' => '23/08/2023',
            'hora' => '14:30',
            'duracion' => '2',
            'maximo_participantes' => '30',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('seminario_presencials')->insert([
            'evento_id' => '20',
            'nombre_ubicacion' => 'Museo Departamental',
            'latitud' => '-34.33781667310125',
            'longitud' => '-56.7143994800415',
            'fecha' => '31/08/2023',
            'hora' => '18:00',
            'duracion' => '1',
            'maximo_participantes' => '100',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('seminario_presencials')->insert([
            'evento_id' => '21',
            'nombre_ubicacion' => 'Club San Jose',
            'latitud' => '-34.33956410856679',
            'longitud' => '-56.713034235645765',
            'fecha' => '24/08/2023',
            'hora' => '21:30',
            'duracion' => '4',
            'maximo_participantes' => '20',
            'created_at' => now(),
            'updated_at' => now(),

        ]);

        DB::table('seminario_presencials')->insert([
            'evento_id' => '22',
            'nombre_ubicacion' => 'Museo Departamental',
            'latitud' => '-34.33781667310125',
            'longitud' => '-56.7143994800415',
            'fecha' => '27/08/2023',
            'hora' => '18:00',
            'duracion' => '1',
            'maximo_participantes' => '100',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
