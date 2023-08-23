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

        $imagenes = [
            "https://media.geeksforgeeks.org/wp-content/cdn-uploads/20230703144619/CPP-Language.png",
            "https://www.dongee.com/tutoriales/content/images/2023/01/image-65.png",
            "https://appmaster.io/api/_files/hRaLG2N4DVjRZJQzCpN2zJ/download/",
            "https://assets.rbl.ms/33364099/origin.jpg",
            "https://www.gss.com.tw/images/easyblog_articles/607/65831-20190206215519247-618941604.jpg",
            "https://i.ytimg.com/vi/lWQ69WX7-hA/maxresdefault.jpg",
            "https://www.hostinger.es/tutoriales/wp-content/uploads/sites/7/2018/11/what-is-html.webp",
            "https://colorlib.com/wp/wp-content/uploads/sites/2/creative-css3-tutorials.jpg",
            "https://cas-training.com/wp-content/uploads/2020/09/angular-todo-lo-que-necesitas-saber.png",
            "https://muytecnologicos.com/wp-content/uploads/2023/01/Ventajas-y-desventajas-de-javascript.jpeg",
            "https://www.fundaciontelefonica.com/wp-content/uploads/2022/10/portada-nanogrado-construccion-762x458-1-762x458.jpg",
            "https://www.solerpalau.com/es-es/blog/wp-content/uploads/2021/08/construcci%C3%B3n-industrializada-1.jpg",
            "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTvfH4LaICXo71ze8qOX2GXl0xjlGpegkG3Cw&usqp=CAU",
            "https://www.construyendoseguro.com/wp-content/uploads/2022/07/Tips-para-desarrollar-un-buen-proyecto-de-construccion.jpg",
            "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcStvOrsMAxouj492sB99u0B1_YMKjEv0Kb6Ng&usqp=CAU",
            "https://ruizhealytimes.com/wp-content/uploads/2020/11/liderazgo-transformacional-1200x799.jpg",
            "https://www.ceupe.com/images/easyblog_articles/1946/b2ap3_large_Liderar-no-es-mandar-1080x675.jpg",
            "https://www.beedigital.es/wp-content/uploads/2020/09/0a26273cca245fc1f6b8fb94bec4d37c354365155-1.jpg",
            "https://www.salesforce.com/content/dam/blogs/br/2021/por-que-investir-em-marketing-digital.jpg",
            "https://classic.exame.com/wp-content/uploads/2021/10/GettyImages-1222811180.jpg?quality=70&strip=info&w=1024",
            "https://colectivoweb.com/wp-content/uploads/2021/08/para-que-sirve-el-marketing-digital.jpg.webp",
            "https://www.rdstation.com/wp-content/uploads/2022/12/marketing-digital.png",
            "https://assets.entrepreneur.com/content/3x2/2000/1691509093-art-of-digital-marketing-g-1370949724.jpg",
            "https://img.freepik.com/foto-gratis/marketing-digital-iconos-gente-negocios_53876-94833.jpg?w=2000",
            "https://www.idt.com.py/wp-content/uploads/2016/09/1124px-Interna-Marketing-Digital.png",
            "https://aglowiditsolutions.com/wp-content/uploads/2022/12/Laravel-Best-Practices.png",
            "https://www.paxinasgalegas.es/blog/gastronomia/los-8-paises-con-la-mejor-gastronomia-del-mundo-img49-n1t0.jpg",
            "https://cnnespanol.cnn.com/wp-content/uploads/2022/12/221229131501-digital-dolar-full-169.jpg?quality=100&strip=info",
        ];

        for ($i = 1; $i <= 5; $i++) {
            DB::table('eventos')->insert([
                'nombre' => 'Introducción a la Programación '.$i,
                'descripcion' => 'Aprende los conceptos básicos de la programación en este curso gratuito. ¡No se requieren conocimientos previos!',
                'imagen' => $imagenes[$i - 1],
                'es_pago' => 0,
                'precio' => 0,
                'organizador_id' => 11,
                'tipo' => 'curso',
                'created_at' => now(),
                'updated_at' => now(),
                'ganancias_acumuladas' => 0
            ]);
        }


        for ($i = 1; $i <= 5; $i++) {
            DB::table('eventos')->insert([
                'nombre' => 'Desarrollo Web Avanzado '.$i,
                'descripcion' => 'Este curso te llevará desde las bases del desarrollo web hasta temas avanzados como seguridad y optimización de rendimiento.',
                'imagen' => $imagenes[$i + 4],
                'es_pago' => 1,
                'precio' => rand(5, 20),
                'organizador_id' => 11,
                'tipo' => 'curso',
                'created_at' => now(),
                'updated_at' => now(),
                'ganancias_acumuladas' => 0
            ]);
        }

        for ($i = 1; $i <= 5; $i++) {
            DB::table('eventos')->insert([
                'nombre' => 'Curso de Construccion '.$i,
                'descripcion' => 'Este curso te llevará desde las bases de la construccion.',
                'imagen' => $imagenes[$i + 10],
                'es_pago' => 1,
                'precio' => rand(5, 20),
                'organizador_id' => 11,
                'tipo' => 'curso',
                'created_at' => now(),
                'updated_at' => now(),
                'ganancias_acumuladas' => 0
            ]);
        }

        for ($i = 1; $i <= 3; $i++) {
            DB::table('eventos')->insert([
                'nombre' => 'Seminario de Liderazgo '.$i,
                'descripcion' => 'Descubre cómo desarrollar habilidades de liderazgo efectivas en este seminario gratuito. Aprenderás a inspirar y motivar a tu equipo.',
                'imagen' => $imagenes[$i + 16],
                'es_pago' => 0,
                'precio' => 0,
                'organizador_id' => 11,
                'tipo' => 'seminarioP',
                'created_at' => now(),
                'updated_at' => now(),
                'ganancias_acumuladas' => 0
            ]);
        }

        for ($i = 1; $i <= 4; $i++) {
            DB::table('eventos')->insert([
                'nombre' => 'Seminario de Marketing Digital '.$i,
                'descripcion' => 'Aprende las estrategias más efectivas para promocionar tus productos y servicios en línea en este seminario de pago.',
                'imagen' => $imagenes[$i + 19],
                'es_pago' => 1,
                'precio' => rand(5, 20),
                'organizador_id' => 11,
                'tipo' => 'seminarioP',
                'created_at' => now(),
                'updated_at' => now(),
                'ganancias_acumuladas' => 0
            ]);
        }

        for ($i = 1; $i <= 3; $i++) {
            DB::table('eventos')->insert([
                'nombre' => 'Seminario de Marketing Digital '.$i,
                'descripcion' => 'Aprende las estrategias más efectivas para promocionar tus productos y servicios en línea en este seminario de pago.',
                'imagen' => $imagenes[$i + 22],
                'es_pago' => 1,
                'precio' => rand(5, 20),
                'organizador_id' => 11,
                'tipo' => 'seminarioV',
                'created_at' => now(),
                'updated_at' => now(),
                'ganancias_acumuladas' => 0
            ]);
        }
        // Cursos
        DB::table('eventos')->insert([
            'nombre' => 'Desarrollo Web con PHP y Laravel',
            'descripcion' => 'Aprende a construir aplicaciones web modernas utilizando PHP y el framework Laravel.',
            'imagen' => $imagenes[25],
            'es_pago' => 1,
            'precio' => 15,
            'organizador_id' => 11,
            'tipo' => 'curso',
            'created_at' => now(),
            'updated_at' => now(),
            'ganancias_acumuladas' => 0
        ]);

        DB::table('eventos')->insert([
            'nombre' => 'Cocina Internacional: Sabores del Mundo',
            'descripcion' => 'Explora recetas y técnicas de cocina de diferentes países en este curso de cocina internacional.',
            'imagen' => $imagenes[26],
            'es_pago' => 1,
            'precio' => 12,
            'organizador_id' => 11,
            'tipo' => 'curso',
            'created_at' => now(),
            'updated_at' => now(),
            'ganancias_acumuladas' => 0
        ]);

        DB::table('eventos')->insert([
            'nombre' => 'Fundamentos de Economía Personal',
            'descripcion' => 'Aprende a manejar tus finanzas personales de manera eficiente y toma decisiones financieras informadas.',
            'imagen' => $imagenes[27],
            'es_pago' => 0,
            'organizador_id' => 11,
            'tipo' => 'curso',
            'created_at' => now(),
            'updated_at' => now(),
            'ganancias_acumuladas' => 0
        ]);


    }
}



