<?php

namespace App\Http\Utils;

use Illuminate\Support\Facades\DB;

class CursoUtils {


public function myBestCalification($estudianteId, $evaluacionId) {
    $myBestCalification = DB::select("SELECT * FROM `calificacions` WHERE estudiante_id=$estudianteId and evaluacion_id=$evaluacionId order by puntuacion desc limit 1");
    if (isset($myBestCalification) && sizeof($myBestCalification) > 0) {
        return $myBestCalification[0];
    } else {
        return null;
    }
}


}
?>