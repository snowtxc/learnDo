<?php

namespace App\Http\Controllers;

use App\Models\colaboracion;
use App\Models\Evento;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Validator;

class ColaboracionController extends Controller
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
            'evento_id' => 'required|integer',
            'colaboradores' => 'required|array',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $colaboradores = $request->input('colaboradores');
        foreach ($colaboradores as $colaborador) {
            $existsColaboracion = colaboracion::where("user_id", "=", $colaborador['id'])->where("evento_id", '=', $request->evento_id)->first();
            if (!isset($existsColaboracion)) {
                $colabToSave = new colaboracion();
                $colabToSave->user_id = $colaborador['id'];
                $userInfo = Usuario::find($colaborador['id']);

                $colabToSave->evento_id = $request->input('evento_id');
                $eventoInfo = Evento::find($request->input('evento_id'));
                $me = Usuario::find($eventoInfo->organizador_id);

                $colabToSave->save();
                $mailController = new MailController("Colaboracion - Learndo", $userInfo->email);
                $mailController->add_colaborador_email($userInfo->nombre, $me->nombre, $eventoInfo->nombre);
            }

        }

        return response()->json([
            'message' => 'Las colaboraciones fueron creadas exitosamente.',
        ], 201);
    }

    public function isUserColaborador(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'evento_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }


        $colabInfo = colaboracion::where("user_id", $request->user_id)
            ->where("evento_id", $request->evento_id)->first();
        if (!isset($colabInfo)) {
            return response()->json([
                "ok" => false,
                'message' => 'Permiso denegado, no eres colaborador para este curso.',
            ], 403);
        }

        return response()->json([
            "ok" => true,
            'message' => 'Éxito, el usuario es colaborador.',
            'colaboracion' => $colabInfo,
        ], 200);
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
     * @param  \App\Models\colaboracion  $colaboracion
     * @return \Illuminate\Http\Response
     */
    public function show(colaboracion $colaboracion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\colaboracion  $colaboracion
     * @return \Illuminate\Http\Response
     */
    public function edit(colaboracion $colaboracion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\colaboracion  $colaboracion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, colaboracion $colaboracion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\colaboracion  $colaboracion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'evento_id' => 'required|integer',
            'user_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $colaboracion = colaboracion::where("user_id", "=", $request->user_id)->where("evento_id", '=', $request->evento_id)->first();
        if (isset($colaboracion)) {
            $colaboracion->delete();
        }

        return response()->json([
            'ok' => true,
            'message' => "Colaborador eliminado correctamente",
        ], 201);
    }
}