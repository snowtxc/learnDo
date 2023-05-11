<?php

namespace App\Http\Controllers;

use App\Models\Opcion;
use Illuminate\Http\Request;
use Validator;

class OpcionController extends Controller
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
            'texto' => 'required',
            'correcta' => 'required|boolean',
            'pregunta_id' => 'required|exists:preguntas,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
    
        $opcion = new Opcion();
        $opcion->contenido = $request->input('texto');
        $opcion->es_correcta = $request->input('correcta');
        $opcion->pregunta_id = $request->input('pregunta_id');
        $opcion->save();
        
        return response()->json([
            'message' => 'La opción se ha creado correctamente.',
            'opcion' => $opcion,
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
     * @param  \App\Models\Opcion  $opcion
     * @return \Illuminate\Http\Response
     */
    public function show(Opcion $opcion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Opcion  $opcion
     * @return \Illuminate\Http\Response
     */
    public function edit(Opcion $opcion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Opcion  $opcion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Opcion $opcion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Opcion  $opcion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Opcion $opcion)
    {
        //
    }
}
