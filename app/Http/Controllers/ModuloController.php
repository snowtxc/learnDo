<?php

namespace App\Http\Controllers;

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
            'estado' => 'required',
            'curso_id' => 'required',
            /*
            'clases' => 'required|array',
            'clases.*.nombre' => 'required',
            'clases.*.duracion' => 'required',
            'clases.*.estado' => 'required',
            'evaluacion' => 'required',
            'evaluacion.nombre' => 'required',
            'evaluacion.maximo_puntuacion' => 'required',
            'evaluacion.preguntas' => 'required|array',
            'evaluacion.preguntas.*.texto' => 'required',
            'evaluacion.preguntas.*.opciones' => 'required|array',
            'evaluacion.preguntas.*.opciones.*.texto' => 'required',
            'evaluacion.preguntas.*.opciones.*.correcta' => 'required|boolean',
            */
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $modulo = new Modulo();
        $modulo->nombre = $request->input('nombre');
        $modulo->estado = $request->input('estado');
        $modulo->curso_id = $request->input('curso_id');
        $modulo->save();

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
