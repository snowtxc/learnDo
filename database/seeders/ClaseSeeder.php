<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('clases')->insert([
            'nombre' => 'Introduccion',
            'descripcion' => 'Clase introductoria para incio del curso',
            'video' => 'http://127.0.0.1:8000/storage/videos/1/JDfTU1eWOCKWwU41dSqvSFedsDueKsHc83VGwnsR.mp4',
            'estado' => 'aprobado',
            'modulo_id' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('clases')->insert([
            'nombre' => 'Clase 2',
            'descripcion' => 'Segunda clase del modulo_id 1',
            'video' => 'http://127.0.0.1:8000/storage/videos/1/JDfTU1eWOCKWwU41dSqvSFedsDueKsHc83VGwnsR.mp4',
            'estado' => 'aprobado',
            'modulo_id' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('clases')->insert([
            'nombre' => 'Clase 23',
            'descripcion' => 'tercera clase del modulo_id 1',
            'video' => 'http://127.0.0.1:8000/storage/videos/1/JDfTU1eWOCKWwU41dSqvSFedsDueKsHc83VGwnsR.mp4',
            'estado' => 'aprobado',
            'modulo_id' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('clases')->insert([
            'nombre' => 'Introduccion',
            'descripcion' => 'Clase introductoria del modulo_id 2',
            'video' => 'http://127.0.0.1:8000/storage/videos/1/JDfTU1eWOCKWwU41dSqvSFedsDueKsHc83VGwnsR.mp4',
            'estado' => 'aprobado',
            'modulo_id' => '2',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('clases')->insert([
            'nombre' => 'Clase 2',
            'descripcion' => 'Segunda clase del modulo_id 2',
            'video' => 'http://127.0.0.1:8000/storage/videos/1/JDfTU1eWOCKWwU41dSqvSFedsDueKsHc83VGwnsR.mp4',
            'estado' => 'aprobado',
            'modulo_id' => '2',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('clases')->insert([
            'nombre' => 'Clase 23',
            'descripcion' => 'tercera clase del modulo_id 2',
            'video' => 'http://127.0.0.1:8000/storage/videos/1/JDfTU1eWOCKWwU41dSqvSFedsDueKsHc83VGwnsR.mp4',
            'estado' => 'aprobado',
            'modulo_id' => '2',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('clases')->insert([
            'nombre' => 'Introduccion',
            'descripcion' => 'Clase introductoria del modulo_id 3',
            'video' => 'http://127.0.0.1:8000/storage/videos/1/JDfTU1eWOCKWwU41dSqvSFedsDueKsHc83VGwnsR.mp4',
            'estado' => 'aprobado',
            'modulo_id' => '3',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('clases')->insert([
            'nombre' => 'Clase 2',
            'descripcion' => 'Segunda clase del modulo_id 3',
            'video' => 'http://127.0.0.1:8000/storage/videos/1/JDfTU1eWOCKWwU41dSqvSFedsDueKsHc83VGwnsR.mp4',
            'estado' => 'aprobado',
            'modulo_id' => '3',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('clases')->insert([
            'nombre' => 'Clase 23',
            'descripcion' => 'tercera clase del modulo_id 3',
            'video' => 'http://127.0.0.1:8000/storage/videos/1/JDfTU1eWOCKWwU41dSqvSFedsDueKsHc83VGwnsR.mp4',
            'estado' => 'aprobado',
            'modulo_id' => '3',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        //===========================================================================

        DB::table('clases')->insert([
            'nombre' => 'Introduccion',
            'descripcion' => 'Clase introductoria para incio del curso',
            'video' => 'http://127.0.0.1:8000/storage/videos/1/JDfTU1eWOCKWwU41dSqvSFedsDueKsHc83VGwnsR.mp4',
            'estado' => 'aprobado',
            'modulo_id' => '4',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('clases')->insert([
            'nombre' => 'Clase 2',
            'descripcion' => 'Segunda clase del modulo_id 1',
            'video' => 'http://127.0.0.1:8000/storage/videos/1/JDfTU1eWOCKWwU41dSqvSFedsDueKsHc83VGwnsR.mp4',
            'estado' => 'aprobado',
            'modulo_id' => '4',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('clases')->insert([
            'nombre' => 'Clase 23',
            'descripcion' => 'tercera clase del modulo_id 1',
            'video' => 'http://127.0.0.1:8000/storage/videos/1/JDfTU1eWOCKWwU41dSqvSFedsDueKsHc83VGwnsR.mp4',
            'estado' => 'aprobado',
            'modulo_id' => '4',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('clases')->insert([
            'nombre' => 'Introduccion',
            'descripcion' => 'Clase introductoria del modulo_id 2',
            'video' => 'http://127.0.0.1:8000/storage/videos/1/JDfTU1eWOCKWwU41dSqvSFedsDueKsHc83VGwnsR.mp4',
            'estado' => 'aprobado',
            'modulo_id' => '5',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('clases')->insert([
            'nombre' => 'Clase 2',
            'descripcion' => 'Segunda clase del modulo_id 2',
            'video' => 'http://127.0.0.1:8000/storage/videos/1/JDfTU1eWOCKWwU41dSqvSFedsDueKsHc83VGwnsR.mp4',
            'estado' => 'aprobado',
            'modulo_id' => '5',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('clases')->insert([
            'nombre' => 'Clase 23',
            'descripcion' => 'tercera clase del modulo_id 2',
            'video' => 'http://127.0.0.1:8000/storage/videos/1/JDfTU1eWOCKWwU41dSqvSFedsDueKsHc83VGwnsR.mp4',
            'estado' => 'aprobado',
            'modulo_id' => '5',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('clases')->insert([
            'nombre' => 'Introduccion',
            'descripcion' => 'Clase introductoria del modulo_id 3',
            'video' => 'http://127.0.0.1:8000/storage/videos/1/JDfTU1eWOCKWwU41dSqvSFedsDueKsHc83VGwnsR.mp4',
            'estado' => 'aprobado',
            'modulo_id' => '6',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('clases')->insert([
            'nombre' => 'Clase 2',
            'descripcion' => 'Segunda clase del modulo_id 3',
            'video' => 'http://127.0.0.1:8000/storage/videos/1/JDfTU1eWOCKWwU41dSqvSFedsDueKsHc83VGwnsR.mp4',
            'estado' => 'aprobado',
            'modulo_id' => '6',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('clases')->insert([
            'nombre' => 'Clase 23',
            'descripcion' => 'tercera clase del modulo_id 3',
            'video' => 'http://127.0.0.1:8000/storage/videos/1/JDfTU1eWOCKWwU41dSqvSFedsDueKsHc83VGwnsR.mp4',
            'estado' => 'aprobado',
            'modulo_id' => '6',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
