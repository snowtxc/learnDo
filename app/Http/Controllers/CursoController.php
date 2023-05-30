<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Foro;
use App\Models\Modulo;
use App\Models\Organizador;
use App\Models\Usuario;
use App\Models\CompraEvento;
use App\Models\Evaluacion;
use App\Models\Calificacion;
use App\Models\Evento;
use App\Models\categoriaevento;
use App\Models\Sugerencia;
use App\Models\Clase;

use Exception;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;
use App\Http\Utils\CursoUtils;
use App\Models\colaboracion;
use App\Models\Estudiante;
use Illuminate\Support\Facades\Auth;


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

    public function __construct()
    {
        $this->middleware('jwt');
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
            $withDetails = $req->withDetails;
            $meInfo = auth()->user();
            $myId = $meInfo->id;
            $cursoInfo = DB::table('eventos')
                ->join('cursos', 'cursos.evento_id_of_curso', '=', 'eventos.id')
                ->select('eventos.id', 'eventos.nombre', 'eventos.imagen', 'eventos.descripcion', 'eventos.es_pago', 'eventos.precio', 'eventos.organizador_id', 'cursos.porcentaje_aprobacion', 'eventos.organizador_id')
                ->where("id", $cursoId)->first();
            if (!isset($cursoInfo)) {
                throw new Exception("Error al obtener la informacion del curso");
            }

            $organizadorInfo = Usuario::where("id", $cursoInfo->organizador_id)->first();
            $categorias = DB::table('categoriaeventos')
                ->join('categorias', 'categoriaeventos.categoria_id', '=', 'categorias.id')
                ->select('categorias.nombre', 'categorias.id')
                ->where("categoriaeventos.evento_id", $cursoId)->get();

            $esComprado = DB::table("compraevento")->where("evento_id", "=", $cursoId)
                ->where("estudiante_id", "=", $myId)->first();

            $cursoUtils = new CursoUtils();
            $calificacionCurso = $cursoUtils->calificacionesOfCurso($cursoId);
            $averageCalificaciones = $calificacionCurso["averageCalificaciones"];
            $countPuntuaciones = $calificacionCurso["countPuntuaciones"];
            $puntuaciones = $calificacionCurso["puntuaciones"];


            $modulos = DB::table("modulos")->where("curso_id", "=", $cursoId)->get();
            $formattedModulos = array();
            if (isset($modulos) && sizeof($modulos) > 0) {
                foreach ($modulos as $modulo) {
                    
                    if ($modulo->estado == "aprobado") {
                        $clasesOfModulo = DB::table("clases")->where("modulo_id", "=", $modulo->id)->get();
                    $evaluacionOfModulo = DB::table("evaluacions")->where("modulo_id", "=", $modulo->id)->first();

                    if (isset($clasesOfModulo) && sizeof($clasesOfModulo) > 0) {
                        $modulo->clases = $clasesOfModulo;
                    } else {
                        $modulo->clases = array();
                    }

                    if (isset($evaluacionOfModulo)) {
                        $cursoUtils = new CursoUtils();
                        $myBestCalification = $cursoUtils->myBestCalification($myId, $evaluacionOfModulo->id);
                        if (isset($myBestCalification)) {
                            $modulo->calificacion = $myBestCalification->puntuacion;
                        } else {
                            $modulo->calificacion = 0;
                        }


                        $modulo->evaluacionId = $evaluacionOfModulo->id;
                        if ($withDetails == true) {
                            $modulo->evaluacionInfo = $cursoUtils->getCompleteEvaluacionInfo($evaluacionOfModulo->id);
                        }
                    } else {
                        $modulo->evaluacionId = null;
                    }

                    array_push($formattedModulos, $modulo);
                    }
                }
            }
            $formatColaboradores = array();
            if ($withDetails) {
                $colaboraciones = colaboracion::where("evento_id", "=", $cursoId)->get();
                if (isset($colaboraciones) && sizeof($colaboraciones) > 0) {
                    foreach ($colaboraciones as $colaboracion) {
                        $infoUser = Usuario::find($colaboracion->user_id);
                        if (isset($infoUser)) {
                            array_push($formatColaboradores, $infoUser);
                            $infoUser = null;
                        }
                    }
                }
            }

            $formatSugerencias = array();
            if ($withDetails) {
                $sugerencias = Sugerencia::where("curso_id", "=", $cursoId)->get();
                if (isset($sugerencias) && sizeof($sugerencias) > 0) {
                    foreach($sugerencias as $sugerencia) {
                        $userInfo = Usuario::find($sugerencia->estudiante_id);
                        
                        $formatModulos = array();
                        $modulos = DB::table("modulos")->where("sugerencia_id", "=",$sugerencia->id)->get();
                        if (isset($modulos)) {
                            foreach($modulos as $modulo) {
                                $clases = Clase::where("sugerencia_id", "=", $sugerencia->id)->where("modulo_id", "=", $modulo->id)->get();
                                if (isset($clases) && sizeof($clases) > 0) {
                                    $modulo->clases = $clases;
                                }
                                array_push($formatModulos, $modulo);
                            }
                        }
                        $sugerencia->userInfo = $userInfo;
                        $sugerencia->modulos = $formatModulos;
                        array_push($formatSugerencias, $sugerencia);
                    }   
                }
            }

            $foro = Foro::where("id_curso", $cursoId)->first();
            $foroId = 0;
            if (isset($foro)) {
                $foroId = $foro->id;
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
                "foroId" => $foroId,
                "colaboradores" => $formatColaboradores,
                "sugerencias" => $formatSugerencias,
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
     * Display the specified resource.
     *
     * @param  \App\Models\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function getCursoAndClases(Request $req)
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
                "modulos" => $formattedModulos,
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

    public function getCursosComprados(Request $req)
    {
        try {
            $cursoUtils = new CursoUtils();
            $validator = Validator::make($req->all(), [
                "estudianteId" => "required|string",
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors());
            }
            $estudianteInfo = Estudiante::where("user_id", "=", $req->estudianteId)->first();
            if (!isset($estudianteInfo)) {
                throw new Exception("El estudiante no existe");
            }
            $misCursos = DB::table("compraevento")->where("estudiante_id", "=", $req->estudianteId)->get();
            $foramtResponse = array();

            if (isset($misCursos) && sizeof($misCursos) > 0) {
                foreach ($misCursos as $miCurso) {
                    $cursoInfo = DB::table('cursos')
                        ->join('eventos', 'cursos.evento_id_of_curso', '=', 'eventos.id')
                        ->select(
                            'eventos.id',
                            'eventos.nombre',
                            'eventos.descripcion',
                            'eventos.imagen',
                            'eventos.es_pago',
                            'eventos.precio',
                            'eventos.organizador_id',
                            'eventos.tipo',
                        )
                        ->where("cursos.evento_id_of_curso", $miCurso->evento_id)->first();
                    $calificacionCurso = $cursoUtils->calificacionesOfCurso($miCurso->evento_id);
                    $averageCalificaciones = $calificacionCurso["averageCalificaciones"];
                    $countPuntuaciones = $calificacionCurso["countPuntuaciones"];

                    if (isset($cursoInfo)) {
                        $cursoInfo->starts = $averageCalificaciones;
                        $cursoInfo->countPuntuaciones = $countPuntuaciones;

                        array_push($foramtResponse, $cursoInfo);
                    }
                }
            }

            return response()->json([
                "ok" => true,
                "cursos" => $foramtResponse
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                "ok" => false,
                "message" => $th->getMessage()
            ]);
        }
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
    public function destroy(Request $req)
    {
        //
    }

    public function canGetCertificate($cursoId, Request $req)
    {

        /* try{*/
        $userInfo = auth()->user();
        $userId = $userInfo["id"];

        $curso = Curso::where(["evento_id_of_curso" => $cursoId])->first();
        if ($curso == null) {
            return response()->json(["message" => "El curso no existe"], 404);
        }
        $userHasPurchasedCourse = CompraEvento::where(["estudiante_id" => $userId, "evento_id" => $cursoId])->count() ? true : false;
        if (!$userHasPurchasedCourse) {
            return response()->json(["message" => "No tienes comprado el curso"], 400);
        }

        $countEvaluations = Modulo::where(["curso_id" => $cursoId])->count(); //la cantidad de modulos es igual a la cantidad de evaluaciones

        if ($countEvaluations <= 0) {
            return response()->json(["message" => "El curso debe tener al menos una evaluacion"], 400);
        }
        $approvalRate = $curso->porcentaje_aprobacion;
        $califications = Calificacion::where(["estudiante_id" => $userId])->get();
        $sumCalifications = 0;
        foreach ($califications as $calification) {
            $sumCalifications += $calification->puntuacion;
        }

        $avgCalifications = floor($sumCalifications / $countEvaluations);

        $isApproved = $avgCalifications >= $approvalRate;

        return response()->json(["result" => $isApproved], 200);

        /* }catch(Exception $e){
             return response()->json(["message" => "Ha ocurrido un error inesperado"] ,500);
         }
          */


    }

    public function updateCursoInfo(Request $req)
    {
        try {
            $validator = Validator::make($req->all(), [
                'nombre' => 'required|string',
                'descripcion' => 'required|string',
                'imagen' => 'required|string',
                'es_pago' => 'required|boolean',
                'precio' => 'required_if:es_pago,true',
                'organizador' => 'required',
                'porcentaje_aprobacion' => 'required_if:tipo,curso',
                'categorias' => "array|required",
                'cursoId' => "required"
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors());
            }

            $eventoInfo = Evento::find($req->cursoId);
            $curoInfo = Curso::where("evento_id_of_curso", "=", $req->cursoId)->first();
            if (!isset($eventoInfo)) {
                throw new Exception("Evento no encontrado");
            }
            if (!isset($eventoInfo)) {
                throw new Exception("Evento no encontrado");
            }

            Evento::where("id", "=", $req->cursoId)->update([
                "nombre" => $req->nombre,
                "descripcion" => $req->descripcion,
                "imagen" => $req->imagen,
                "es_pago" => $req->es_pago,
                "precio" => $req->precio,
            ]);
            Curso::where("evento_id_of_curso", "=", $req->cursoId)->update([
                "porcentaje_aprobacion" => $req->porcentaje_aprobacion,
            ]);


            $categorias = $req->categorias;
            if (isset($categorias) && sizeof($categorias) > 0) {
                foreach ($categorias as $categoria) {
                    $categoriaExists = categoriaevento::where("evento_id", "=", $req->cursoId)->where("categoria_id", "=", $categoria)->first();
                    if (!isset($categoriaExists)) {
                        $categoriaEvento = new categoriaevento();
                        $categoriaEvento->evento_id = $req->cursoId;
                        $categoriaEvento->categoria_id = $categoria;
                        $categoriaEvento->save();
                    }
                }
            }

            $categoriasOfEvento = categoriaevento::where("evento_id", "=",  $req->cursoId)->get();
            if (isset($categoriasOfEvento) && sizeof($categoriasOfEvento) > 0) {
                echo "1";
                if (sizeof($categorias) < sizeof($categoriasOfEvento)) {
                    foreach($categoriasOfEvento as $catEvento) {
                        if (!in_array($catEvento->categoria_id, $categorias)) {
                            // delete
                            $catEvento->delete();
                        }
                    }
                }
            }
            return response()->json([
                "ok" => false,
                "message" => "Curso actualizado correctamente",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "ok" => false,
                "message" => $th->getMessage(),
            ]);
        }

    }
}