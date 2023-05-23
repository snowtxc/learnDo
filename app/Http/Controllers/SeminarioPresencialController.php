<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\SeminarioPresencial;
use Illuminate\Http\Request;
use App\Models\SeminarioVirtual;
use Validator;

class SeminarioPresencialController extends Controller
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
            'evento_id' => 'required',
            'nombre_ubicacion' => 'required',
            'latitud' => 'required',
            'longitud' => 'required',
            'maximo_participantes' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $seminario = new SeminarioPresencial();
        $seminario->evento_id = $request->input('evento_id');
        $seminario->nombre_ubicacion = $request->input('nombre_ubicacion');
        $seminario->latitud = $request->input('latitud');
        $seminario->longitud = $request->input('longitud');
        $seminario->maximo_participantes = $request->input('maximo_participantes');
        $seminario->save();

        return response()->json([
            'message' => 'El seminario se ha creado correctamente.',
            'curso' => $seminario,
        ], 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function listarSeminariosPresenciales(Request $request)
    {
        try {
            $seminarios = SeminarioPresencial::all();
            $formattedSeminarios = array();
            foreach ($seminarios as $seminario) {
                $eventoInfo = Evento::find($seminario->evento_id);
                $newItem = [
                    "latitud" => $seminario->latitud,
                    "longitud" => $seminario->longitud,
                    "fecha" => $seminario->fecha,
                    "hora" => $seminario->hora,
                    "duracion" => $seminario->duracion,
                    "maximo_participantes" => $seminario->maximo_participantes,
                    "imagen" => $eventoInfo->imagen,
                    "precio" => $eventoInfo->precio,
                    "nombre" => $eventoInfo->nombre,
                    "descripcion" => $eventoInfo->descripcion,
                ];
                array_push($formattedSeminarios, $newItem);
            }

            return response()->json([
                "ok" => true,
                "seminarios" => $formattedSeminarios,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "ok" => false,
                "message" => $th->getMessage(),
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
     * @param  \App\Models\SeminarioPresencial  $seminarioPresencial
     * @return \Illuminate\Http\Response
     */
    public function show(SeminarioPresencial $seminarioPresencial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SeminarioPresencial  $seminarioPresencial
     * @return \Illuminate\Http\Response
     */
    public function edit(SeminarioPresencial $seminarioPresencial)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SeminarioPresencial  $seminarioPresencial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SeminarioPresencial $seminarioPresencial)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SeminarioPresencial  $seminarioPresencial
     * @return \Illuminate\Http\Response
     */
    public function destroy(SeminarioPresencial $seminarioPresencial)
    {
        //
    }
}