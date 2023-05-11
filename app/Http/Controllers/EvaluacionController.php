<?php

namespace App\Http\Controllers;

use App\Models\Evaluacion;
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
        $validator = Validator::make($request->all(),[
            'nombre' => 'required',
            'maximo_puntuacion' => 'required',
            'modulo_id' => 'required',
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
        $evaluacion->nombre = $request->input('nombre');
        $evaluacion->maximo_puntuacion = $request->input('maximo_puntuacion');
        $evaluacion->modulo_id = $request->input('modulo_id');
        $evaluacion->save();
    
        foreach ($request->input('preguntas') as $preguntaData) {
            $pregunta = new PreguntaController();
            $preguntaController = new Request();
            $preguntaController->texto = $preguntaData['texto'];
            $preguntaController->evaluacion_id = $request['$id'];
            $preguntaController->opciones = $preguntaData['opciones'];
            $pregunta->create($preguntaController);
        }

        return response()->json([
            'message' => 'La evaluación se ha creado correctamente.',
            'evaluacion' => $evaluacion,
        ], 201);
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
