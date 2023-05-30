<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use App\Models\Modulo;
use App\Models\Sugerencia;
use Exception;
use Illuminate\Http\Request;
use Validator;

class SugerenciaController extends Controller
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
        $validator = Validator::make($request->all(), [
            'contenido' => 'required',
            'estado' => 'required|in:aprobado,rechazado,pendiente',
            'curso_id' => 'required',
            'estudiante_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $sugerencia = new Sugerencia();
        $sugerencia->contenido = $request->contenido;
        $sugerencia->estado = $request->estado;
        $sugerencia->curso_id = $request->curso_id;
        $sugerencia->estudiante_id = $request->estudiante_id;
        $sugerencia->save();

        // Clase::where("id", $request->id_clase)->update(['video' => $videoPath]);

        return response()->json([
            'message' => 'La sugerencia se ha creado correctamente.',
            'sugerencia' => $sugerencia,
        ], 201);
    }

    public function changeStatus(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'sugerencia_id' => 'required|int',
                'estado' => 'required|in:aprobado,rechazado,pendiente',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors());
            }

            $sugerencia = Sugerencia::find($request->sugerencia_id);
            if (!isset($sugerencia)) {
                throw new Exception("Sugerencia no encontrada");
            }

            Sugerencia::where("id", "=", $sugerencia->id)->update([
                "estado" => $request->estado,
            ]);

            Modulo::where("sugerencia_id", "=", $sugerencia->id)->update([
                "estado" => $request->estado,
            ]);

            Clase::where("sugerencia_id", "=", $sugerencia->id)->update([
                "estado" => $request->estado,
            ]);

            return response()->json([
                'message' => 'La sugerencia se ha actualizado correctamente.',
                'ok' => true,
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'ok' => false,
            ], 201);
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
     * @param  \App\Models\Sugerencia  $sugerencia
     * @return \Illuminate\Http\Response
     */
    public function show(Sugerencia $sugerencia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sugerencia  $sugerencia
     * @return \Illuminate\Http\Response
     */
    public function edit(Sugerencia $sugerencia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sugerencia  $sugerencia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sugerencia $sugerencia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sugerencia  $sugerencia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sugerencia $sugerencia)
    {
        //
    }
}