<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Modulo;
use App\Models\Organizador;
use App\Models\Usuario;
use Exception;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function getInfoCurso(Request $req)
    {
        $validator = Validator::make($req->all(), [
            "id" => "required|string",
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $curso = DB::table('eventos')
            ->join('cursos', 'cursos.id', '=', 'eventos.id')
            ->select('eventos.id', 'eventos.nombre', 'eventos.descripcion', 'eventos.es_pago', 'eventos.precio', 'eventos.organizador_id', 'eventos.categoria_id', 'cursos.porcentaje_aprobacion', 'cursos.ganancias_acumuladas')
            ->where("id", $req->id)->first();

        if (!isset($curso)) {
            return response([], 404);
        }

        return response()->json($curso, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'porcentaje_aprobacion' => '',
            'ganancias' => '',
            'evento_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $curso = new Curso();
        $curso->porcentaje_aprobacion = $request->input('porcentaje_aprobacion');
        $curso->ganancias_acumuladas = $request->input('ganancias');
        $curso->evento_id_of_curso = $request->input('evento_id');
        $curso->save();

        return response()->json([
            'message' => 'El curso se ha creado correctamente.',
            'curso' => $curso,
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function getCursoInfo(Request $req)
    {
        try {
            $cursoId = $req->cursoId;
            if (!isset($cursoId)) {
                throw new Exception("Error al obtener la informacion del curso");
            }
            $meInfo = auth()->user();
            $myId = $meInfo->id;
            $cursoInfo = DB::table('eventos')
                ->join('cursos', 'cursos.evento_id_of_curso', '=', 'eventos.id')
                ->select('eventos.id', 'eventos.nombre', 'eventos.imagen', 'eventos.descripcion', 'eventos.es_pago', 'eventos.precio', 'eventos.organizador_id', 'cursos.porcentaje_aprobacion', 'eventos.organizador_id')
                ->where("id", $cursoId)->first();
            if (!isset($cursoInfo)) {
                throw new Exception("Error al obtener la informacion del curso");
            }

            $organizadorInfo = Usuario::where("id",$cursoInfo->organizador_id)->first();
            $categorias = DB::table('categoriaeventos')
                ->join('categorias', 'categoriaeventos.categoria_id', '=', 'categorias.id')
                ->select('categorias.nombre')
                ->where("categoriaeventos.evento_id", $cursoId)->get();

            $esComprado = DB::table("compraevento")->where("evento_id", "=", $cursoId)
                ->where("user_id", "=", $myId)->first();

            $puntuaciones = DB::table("puntuacions")->where("curso_id", "=", $cursoId)->get();
            // echo $puntuaciones;
            $averageCalificaciones = 0;
            $countPuntuaciones = 0;
            if (isset($puntuaciones) && sizeof($puntuaciones) > 0) {
                $sumPuntuaciones = 0;
                $countPuntuaciones = sizeof($puntuaciones);
                foreach ($puntuaciones as $puntuacion) {
                    $userInfo = Usuario::find($puntuacion->estudiante_id);
                    $puntuacion->userName = $userInfo->nickname;
                    $puntuacion->userImage = $userInfo->imagen;
                    $sumPuntuaciones += $puntuacion->puntuacion;
                }
                $averageCalificaciones = $sumPuntuaciones / $countPuntuaciones;
            }

            $modulos = DB::table("modulos")->where("curso_id", "=", $cursoId)->get();
            $formattedModulos = array();
            if (isset($modulos) && sizeof($modulos) > 0) {
                foreach ($modulos as $modulo) {
                    $clasesOfModulo = DB::table("clases")->where("modulo_id", "=", $modulo->id)->get();
                    if (isset($clasesOfModulo) && sizeof($clasesOfModulo) > 0) {
                        $modulo->clases = $clasesOfModulo;
                    } else {
                        $modulo->clases = array();
                    }
                    array_push($formattedModulos, $modulo);
                }
            }

            return response()->json([
                "ok" => true,
                "curso" => $cursoInfo,
                "categorias" => $categorias,
                "comprado" => isset($esComprado),
                "stars" => $averageCalificaciones,
                "countPuntuaciones" => $countPuntuaciones,
                "modulos" => $formattedModulos,
                "puntuaciones" => $puntuaciones,
                "profesor" => $organizadorInfo->nombre,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "ok" => false,
                "message" => $th->getMessage(),
            ]);
        }
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function show(Curso $curso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function edit(Curso $curso)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Curso $curso)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function destroy(Curso $curso)
    {
        //
    }
}