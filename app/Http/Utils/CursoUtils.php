<?php

namespace App\Http\Utils;

use App\Models\Usuario;
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
        );

    }


}
?>