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
use App\Models\Certificado;
use App\Models\Sugerencia;
use App\Models\Evento;


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
            $certificate = Certificado::where(["estudiante_id" => $myId, "curso_id"=> $cursoInfo->id])->first();

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
                "certificateID" => $certificate != null ? $certificate->id : null 
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
                    $cursoUtils = new CursoUtils();
                    $calificacionCurso = $cursoUtils->calificacionesOfCurso($miCurso->evento_id);
                    $averageCalificaciones = $calificacionCurso["averageCalificaciones"];
                    $countPuntuaciones = $calificacionCurso["countPuntuaciones"];

                    $certificate = Certificado::where(["estudiante_id" => $req->estudianteId , "curso_id"=> $cursoInfo->id])->first();
                    $cursoInfo->certificateID = $certificate != null ? $certificate->id : null;


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

    public function getProgresoEstudiantes(Request $req) {
        try {
            $validator = Validator::make($req->all(), [
                "cursoId" => "required|string",
                "userId" => "required|string",
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors());
            }
            $eventoInfo = Evento::find($req->cursoId);
            $cursoInfo = Curso::where("evento_id_of_curso", "=", $req->cursoId)->first();

            if (!isset($eventoInfo) || !isset($cursoInfo)) {
                throw new Exception("Curso invalido");
            }
            $userInfo = Usuario::find($req->userId);
            if (!isset($userInfo)) {
                throw new Exception("Usuario invalido");
            }
            if ($eventoInfo->organizador_id != $req->userId) {
                throw new Exception("Permiso denegado");
            }
            $estudianteCompra = CompraEvento::where("evento_id", "=", $req->cursoId)->get();
            $estudiantesFormat = array();
            if (isset($estudianteCompra)  && sizeof($estudianteCompra) > 0) {
                foreach($estudianteCompra as $compraEstu) {
                    $userInfo = Usuario::find($compraEstu->estudiante_id);
                    if (isset($userInfo)) {
                        $compraEstu->userInfo = $userInfo;
                    }
                    $cursoUtils = new CursoUtils();
                    $result =  $cursoUtils->canStudentGetCertificate($userInfo->id, $eventoInfo->id,$cursoInfo->porcentaje_aprobacion);  
                    if (isset($result)) {
                        $compraEstu->progreso = $result;
                    }
                    array_push($estudiantesFormat, $compraEstu);
                }
            }
    
            return response()->json([
                "ok" => true,
                "cursoInfo" => $cursoInfo,
                "eventoInfo" => $eventoInfo,
                "estudiantes" => $estudiantesFormat,
            ]);
            //code...
        } catch (\Throwable $th) {
            return response()->json([
                "ok" => false,
                "message" => $th->getMessage()
            ]);
        }
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

        try{
            $userInfo = auth()->user();
            $userId  = $userInfo["id"];
    
            $curso = Curso::where(["evento_id_of_curso" => $cursoId])->first();
            if($curso == null){
                return response()->json(["message" => "El curso no existe"] ,404);
            }

            $cursoUtils = new CursoUtils();
            $result =  $cursoUtils->canStudentGetCertificate($userId, $cursoId,$curso->porcentaje_aprobacion);  
            return response()->json( $result ,200);   

         }catch(Exception $e){
            return response()->json(["message" => "Ha ocurrido un error inesperado"] ,500);
        }
           

    }


      /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function studentAlreadyHasCertificate($cursoId ,Request $req){

        $userInfo = auth()->user();
        $userId  = $userInfo["id"];

        $curso = Curso::where(["evento_id_of_curso"=> $cursoId]);  

        if($curso == null){
            return response()->json(["message" => "Curso no existe"] ,400);
        }
        $alreadyHasCertificate =  Certificado::where(["estudiante_id" => $userId,  "curso_id" => $curso->id])->count() > 0;
        
        return response()->json( $alreadyHasCertificate ,200);  

    }

}