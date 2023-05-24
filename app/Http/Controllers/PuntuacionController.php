<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Estudiante;
use App\Models\Puntuacion;
use Exception;
use Illuminate\Http\Request;
use Validator;

class PuntuacionController extends Controller
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
    public function puntuarCurso(Request $req)
    {
        try {
            $validator = Validator::make($req->all(), [
                "description" => "required|string",
                "userId" => "required",
                "cursoId" => "required",
                "rating" => "required",
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors());
            }

            $userExists = Estudiante::where("user_id", $req->userId);
            if (!isset($userExists)) {
                throw new Exception("Error, el usuario no existe");
            }
            $cursoExists = Curso::where("evento_id_of_curso",$req->cursoId);
            if (!isset($cursoExists)) {
                throw new Exception("Error, el curso no existe");
            }

            $puntuacion = new Puntuacion();
            $puntuacion->puntuacion = $req->rating;
            $puntuacion->descripcion = $req->description;
            $puntuacion->estudiante_id = $req->userId;
            $puntuacion->curso_id = $req->cursoId;
            $puntuacion->save();

            return response()->json([
                "ok" => true,
                "message" => "Calificacion creada correctamente",
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
     * @param  \App\Models\Puntuacion  $puntuacion
     * @return \Illuminate\Http\Response
     */
    public function show(Puntuacion $puntuacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Puntuacion  $puntuacion
     * @return \Illuminate\Http\Response
     */
    public function edit(Puntuacion $puntuacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Puntuacion  $puntuacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Puntuacion $puntuacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Puntuacion  $puntuacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Puntuacion $puntuacion)
    {
        //
    }
}