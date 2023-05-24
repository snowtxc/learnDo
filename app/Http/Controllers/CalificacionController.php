<?php

namespace App\Http\Controllers;

use App\Models\Calificacion;
use App\Models\Evaluacion;
use App\Models\Opcion;
use Exception;
use Illuminate\Http\Request;
use Validator;

class CalificacionController extends Controller
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function correjirCalificacion(Request $req)
    {
        try {
            $validator = Validator::make($req->all(), [
                'respuestas' => 'required|array',
                'evaluacionId' => 'required|integer'
            ]);

            $myId = auth()->user()->id;

            $evaluacionInfo = Evaluacion::find($req->evaluacionId);
            if (!isset($evaluacionInfo)) {
                throw new Exception("Error al obtener la evaluacion");
            }

            $respuestas = $req->respuestas;
            $totalRespuestas = sizeof($respuestas);
            $cantCorrectas = 0;
            foreach ($respuestas as $respuesta) {
                $correctRespuesta = Opcion::where("pregunta_id", "=", $respuesta["id"])
                    ->where("es_correcta", "=", "1")->first();
                if ($correctRespuesta->id == $respuesta['opcioneCorrecta']) {
                    $cantCorrectas += 1;
                }
            }

            $aprobacion = ($cantCorrectas / $totalRespuestas) * 100;

            if ($validator->fails()) {
                return response()->json($validator->errors());
            }
            
            $newCalificacion = new Calificacion();
            $newCalificacion->puntuacion = $aprobacion;
            $newCalificacion->estudiante_id = $myId;
            $newCalificacion->evaluacion_id = $req->evaluacionId;
            $newCalificacion->save();
            return response()->json([
                "ok" => true,
                "message" => "Correjido correctamente",
                "aproacion" => $aprobacion,
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                "ok" => false,
                "message" => $th->getMessage()
            ]);
        }
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
     * @param  \App\Models\Calificacion  $calificacion
     * @return \Illuminate\Http\Response
     */
    public function show(Calificacion $calificacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Calificacion  $calificacion
     * @return \Illuminate\Http\Response
     */
    public function edit(Calificacion $calificacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Calificacion  $calificacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Calificacion $calificacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Calificacion  $calificacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Calificacion $calificacion)
    {
        //
    }
}