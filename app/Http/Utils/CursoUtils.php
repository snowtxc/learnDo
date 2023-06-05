<?php

namespace App\Http\Utils;

use App\Models\Evaluacion;
use App\Models\Opcion;
use App\Models\Pregunta;
use App\Models\Usuario;
use App\Models\CompraEvento; 
use App\Models\Modulo; 
use App\Models\Certificado; 
use App\Models\Calificacion; 


use Illuminate\Support\Facades\DB;

class CursoUtils
{


    public function myBestCalification($estudianteId, $evaluacionId)
    {
        $myBestCalification = DB::select("SELECT * FROM `calificacions` WHERE estudiante_id=$estudianteId and evaluacion_id=$evaluacionId order by puntuacion desc limit 1");
        if (isset($myBestCalification) && sizeof($myBestCalification) > 0) {
            return $myBestCalification[0];
        } else {
            return null;
        }
    }

    public function calificacionesOfCurso($cursoId)
    {
        $countEstudiantes = DB::table("compraevento")->where("evento_id", "=", $cursoId)->count();
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
        return array(
            "averageCalificaciones" => $averageCalificaciones,
            "countPuntuaciones" => $countPuntuaciones,
            "puntuaciones" => $puntuaciones,
            "countEstudiantes" => $countEstudiantes,
        );
    }


    public function canStudentGetCertificate($studentId, $cursoId, $approvalRate)
    {          

            $userHasPurchasedCourse =  CompraEvento::where(["estudiante_id" => $studentId, "evento_id" => $cursoId])->count() ? true : false;
            if(!$userHasPurchasedCourse){
                return false; 
            }
            
            $modulos = Modulo::where(["curso_id" => $cursoId])->get();  
            $countEvaluations = count($modulos); //la cantidad de modulos es igual a la cantidad de evaluaciones
            if($countEvaluations <= 0){
                return false;
            }

            $sumCalifications = 0;
            foreach($modulos as $modulo){
                $evaluacion =  Evaluacion::where(["modulo_id" => $modulo->id])->first();
                $cal  = Calificacion::where(["estudiante_id" => $studentId, "evaluacion_id" => $evaluacion->id])->first();
                if($cal != null){
                    $sumCalifications += $cal->puntuacion;
                }

            }              
            $avgCalifications  = floor($sumCalifications/$countEvaluations); 
            $isApproved = $avgCalifications >= $approvalRate;

            $result = array(
                "avgCalifications" => $avgCalifications, 
                "isApproved" => $isApproved
            );
            return $result;

    }

    public function getCompleteEvaluacionInfo($evaluacionId)
    {
       try {
        $evaluacionInfo = Evaluacion::find($evaluacionId);
        if (!isset($evaluacionInfo)) return null;

        $preguntas = Pregunta::where("evaluacion_id", "=", $evaluacionId)->get();
        $formatPreguntas = array();
        if (isset($preguntas)) {
            foreach($preguntas as $pregunta) {
                $opciones = Opcion::where("pregunta_id", "=", $pregunta->id)->get();
                if (isset($opciones)) {
                    $pregunta->opciones = $opciones;
                }
                array_push($formatPreguntas, $pregunta);
            }
        }
        $evaluacionInfo->preguntas = $formatPreguntas;
        return $evaluacionInfo;
       } catch (\Throwable $th) {
        echo "Error getting completeEvaluacionInfo";
        return null;
       }
    }

    


}
?>

