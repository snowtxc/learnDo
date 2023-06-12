<?php

namespace Database\Seeders;

use App\Models\Evento;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('eventos')->insert([
            //'id' => '1',
            'nombre' => 'Programacion php',
            'descripcion' => 'En este curso aprenderas el manejo de php y algunos de sus frameworks mas populares',
            'imagen' => 'https://firebasestorage.googleapis.com/v0/b/learndo-39568.appspot.com/o/profileImages%2F1686147779446Dimansions.JPG?alt=media&token=4c8444bb-c317-4e31-8943-61816c38f614',
            'es_pago' => '1',
            'precio' => '5',
            'organizador_id' => '4',
            'tipo' => 'curso',
            'created_at' => now(),
            'updated_at' => now(),
            'ganancias_acumuladas' => 0
        ]);

        
        DB::table('eventos')->insert([
            //'id' => '2',
            'nombre' => 'Alta cocina',
            'descripcion' => '¿Quieres concinar profesionalmente?, ¡Este es el curso que buscas!',
            'imagen' => 'https://firebasestorage.googleapis.com/v0/b/learndo-39568.appspot.com/o/profileImages%2F1686147779446Dimansions.JPG?alt=media&token=4c8444bb-c317-4e31-8943-61816c38f614',
            'es_pago' => '1',
            'precio' => '4',
            'organizador_id' => '4',
            'tipo' => 'curso',
            'created_at' => now(),
            'updated_at' => now(),
            'ganancias_acumuladas' => 0
        ]);

        DB::table('eventos')->insert([
            //'id' => '3',
            'nombre' => 'Mecanica Automotriz',
            'descripcion' => 'Reparacion de autos, camionetas y mas, no te lo pierdas ¡Es Gratis!',
            'imagen' => 'https://firebasestorage.googleapis.com/v0/b/learndo-39568.appspot.com/o/profileImages%2F1686147779446Dimansions.JPG?alt=media&token=4c8444bb-c317-4e31-8943-61816c38f614',
            'es_pago' => '0',
            'organizador_id' => '4',
            'tipo' => 'seminarioP',
            'created_at' => now(),
            'updated_at' => now(),
            'ganancias_acumuladas' => 0
        ]);

        DB::table('eventos')->insert([
            //'id' => '4',
            'nombre' => 'Charla Primerios Auxilios',
            'descripcion' => '¿Que hacer ante un accidente?, ¿Como debo actuar ante una herida expuesta?, resolveremos esas dudas en este seminario',
            'imagen' => 'https://firebasestorage.googleapis.com/v0/b/learndo-39568.appspot.com/o/profileImages%2F1686147779446Dimansions.JPG?alt=media&token=4c8444bb-c317-4e31-8943-61816c38f614',
            'es_pago' => '1',
            'precio' => '8',
            'organizador_id' => '4',
            'tipo' => 'seminarioP',
            'created_at' => now(),
            'updated_at' => now(),
            'ganancias_acumuladas' => 0
        ]);

        DB::table('eventos')->insert([
            //'id' => '4',
            'nombre' => 'Modelos de negocio',
            'descripcion' => '¿cuales son los modelos de negocio mas rentables de 2023?',
            'imagen' => 'https://firebasestorage.googleapis.com/v0/b/learndo-39568.appspot.com/o/profileImages%2F1686147779446Dimansions.JPG?alt=media&token=4c8444bb-c317-4e31-8943-61816c38f614',
            'es_pago' => '1',
            'precio' => '4',
            'organizador_id' => '4',
            'tipo' => 'seminarioP',
            'created_at' => now(),
            'updated_at' => now(),
            'ganancias_acumuladas' => 0
        ]);

        DB::table('eventos')->insert([
            //'id' => '4',
            'nombre' => 'Criptomonedas y tecnologia blockchain',
            'descripcion' => 'Todo lo que debes saber de tecnologia blockchain, criptomonedas y nfts',
            'imagen' => 'https://firebasestorage.googleapis.com/v0/b/learndo-39568.appspot.com/o/profileImages%2F1686147779446Dimansions.JPG?alt=media&token=4c8444bb-c317-4e31-8943-61816c38f614',
            'es_pago' => '1',
            'precio' => '10',
            'organizador_id' => '4',
            'tipo' => 'seminarioP',
            'created_at' => now(),
            'updated_at' => now(),
            'ganancias_acumuladas' => 0
        ]);
    }
}
