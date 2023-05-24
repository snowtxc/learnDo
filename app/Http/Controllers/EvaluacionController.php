<?php

namespace App\Http\Controllers;

use App\Models\Evaluacion;
use App\Models\Opcion;
use App\Models\Pregunta;
use Exception;
use Illuminate\Http\Request;
use Validator;

class EvaluacionController extends Controller
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
    public function create(Request $request)
    {
        $validator = Validator::make($request->evaluacion, [
            // para enviar en el body evaluacion: data,
            'nombre' => 'required',
            'maximo_puntuacion' => 'required',
            'preguntas' => 'required|array',
            'modulo_id' => '',
            /*
            'preguntas' => 'required|array|min:1',
            'preguntas.*.texto' => 'required',
            'preguntas.*.opciones' => 'required|array|min:4',
            'preguntas.*.opciones.*.texto' => 'required',
            'preguntas.*.opciones.*.correcta' => 'required|boolean',
            */
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $evaluacion = new Evaluacion();
        // echo $request->evaluacion['nombre'];
        // echo var_dump($request->evaluacion);
        $evaluacion->nombre = $request->evaluacion['nombre'];
        $evaluacion->maximo_puntuacion = $request->evaluacion['maximo_puntuacion'];
        $evaluacion->modulo_id = $request->evaluacion['modulo_id'];
        $evaluacion->save();

        $preguntas = $request->evaluacion['preguntas'];
        foreach ($preguntas as $preguntaData) {
            echo var_dump($preguntaData['texto']);
            $preguntaToSave = new Pregunta();
            $preguntaToSave->texto = $preguntaData['texto'];
            $preguntaToSave->evaluacion_id = $evaluacion->id;
            $preguntaToSave->save();
            $preguntaToSave->opciones = $preguntaData['opciones'];
        }

        return response()->json([
            'message' => 'La evaluación se ha creado correctamente.',
            'evaluacion' => $evaluacion,
        ], 201);
    }

    public function createWithoutRequest($modulo_id, $evaluacionACrear)
    {
        $validator = Validator::make($evaluacionACrear, [
            'nombre' => 'required',
            'maximo_puntuacion' => 'required',
            'preguntas' => 'required|array',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $evaluacion = new Evaluacion();
        // echo $request->evaluacion['nombre'];
        // echo var_dump($evaluacion);
        $evaluacion->nombre = $evaluacionACrear['nombre'];
        $evaluacion->maximo_puntuacion = $evaluacionACrear['maximo_puntuacion'];
        $evaluacion->modulo_id = $modulo_id;
        $evaluacion->save();

        $preguntas = $evaluacionACrear['preguntas'];
        foreach ($preguntas as $preguntaData) {
            // echo var_dump($preguntaData['texto']);
            $preguntaToSave = new Pregunta();
            $preguntaToSave->contenido = $preguntaData['contenido'];
            $preguntaToSave->evaluacion_id = $evaluacion->id;
            $preguntaToSave->save();
            $preguntaToSave->opciones = $preguntaData['opciones'];
            foreach ($preguntaData['opciones'] as $opcion) {
                $opController = new OpcionController();
                $opController->createWithoutRequest($preguntaToSave->id, $opcion);
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getInfo(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'evaluacionId' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors());
            }

            $evaluacionInfo = Evaluacion::find($request->evaluacionId);

            if (!isset($evaluacionInfo)) {
                throw new Exception("Error , evaluacion invalida");
            }

            $preguntas = Pregunta::where("evaluacion_id", "=", $evaluacionInfo->id)->get();
            $filterPreguntas = array();

            if (isset($preguntas) && sizeof($preguntas) > 0) {
                foreach ($preguntas as $pregunta) {
                    $opciones = Opcion::where("pregunta_id", "=", $pregunta->id)->get();
                    $filterOpciones = array();
                    foreach($opciones as $opcion) {
                        $newPregunta = [
                            "id" =>  $opcion->id,
                            "contenido" => $opcion->contenido,
                        ];
                        array_push($filterOpciones, $newPregunta);
                    }
                    $pregunta->opciones = $filterOpciones;
                    array_push($filterPreguntas, $pregunta);
                }
            }
           
            

            return response()->json([
                "ok" => true,
                "evaluacion" => $evaluacionInfo,
                "preguntas" => $filterPreguntas
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
     * @param  \App\Models\Evaluacion  $evaluacion
     * @return \Illuminate\Http\Response
     */
    public function show(Evaluacion $evaluacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Evaluacion  $evaluacion
     * @return \Illuminate\Http\Response
     */
    public function edit(Evaluacion $evaluacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Evaluacion  $evaluacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Evaluacion $evaluacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Evaluacion  $evaluacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Evaluacion $evaluacion)
    {
        //
    }
}