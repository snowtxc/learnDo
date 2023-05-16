<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use App\Models\Evaluacion;
use App\Models\Modulo;
use Illuminate\Http\Request;
use Validator;

class ModuloController extends Controller
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
            'estado' => 'required|in:aprobado,rechazado,pendiente',
            'curso_id' => 'required',
            'evaluacion' => '',
            'clases' => 'array',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $modulo = new Modulo();
        $modulo->nombre = $request->input('nombre');
        $modulo->estado = $request->input('estado');
        $modulo->curso_id = $request->input('curso_id');
        $modulo->save();

        $evaluacion = $request->input('evaluacion');
        if(isset($evaluacion)){
            $evController = new EvaluacionController();
            $evController->createWithoutRequest($modulo->id, $evaluacion);
        }


        $clases = $request->input('clases');
        foreach ($clases as $clase) {
            $claseToSave = new Clase();
            $claseToSave->nombre = $clase['nombre'];
            $claseToSave->video = $clase['video'];
            $claseToSave->duracion = $clase['duracion'];
            $claseToSave->estado = 'aprobado';
            $claseToSave->modulo_id = $modulo->id;
            $claseToSave->save();
        }

        return response()->json([
            'message' => 'El modulo se ha creado correctamente',
            'modulo' => $modulo,
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
     * @param  \App\Models\Modulo  $modulo
     * @return \Illuminate\Http\Response
     */
    public function show(Modulo $modulo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Modulo  $modulo
     * @return \Illuminate\Http\Response
     */
    public function edit(Modulo $modulo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Modulo  $modulo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Modulo $modulo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Modulo  $modulo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Modulo $modulo)
    {
        //
    }
}
