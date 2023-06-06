<?php

namespace App\Http\Controllers;

use App\Models\MensajeSala;
use App\Models\SeminarioVirtual;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Validator;
use App\Http\Utils\UserUtils;
use Carbon\Carbon;




class MensajeSalaController extends Controller
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

    public function __construct()
    {
        $this->middleware('jwt');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($seminarioVId, Request $req)
    {
        $validator = Validator::make($req->all(), [
            "contenido" => "required|string",
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $userInfo = auth()->user();
        $userId  = $userInfo["id"];
        
        $userUtils = new UserUtils();
        $user = $userUtils->userExists($userId);

        if ($user  == null) {
            return response()->json([
                "ok" => false,
                "message" => "Datos invalidos"
            ]);
        }


        $seminarioVData =  SeminarioVirtual::where(["evento_id" => $seminarioVId])->first();
        if($seminarioVData == null){
            return response()->json([
                "ok" => false,
                "message" => "No existe este seminario virtual"
            ], 404);

        }

        $userIsOwnerOrStudent  = Evento::where(["evento_id" => $seminarioVId, "organizador_id" => $userId])->count() > 0 ||  CompraEvento::where(["evento_id" => $seminarioVId, "estudiante_id" => $userId])->count() > 0 ;
        if(!$userIsOwnerOrStudent){
            return response()->json([
                "ok" => false,
                "message" => "Debes ser un estudiante o organizador del evento para el chat en vivo"
            ], 404);
        }

        $mensaje = new MensajeSala();
        $mensaje->user_id = $userId;
        $mensaje->conenido = $req->contenido;
        $mensaje->fecha_emision = Carbon::now();
        $mensaje->seminario_virtual_id = $seminarioVId;
        $mensaje->save();

        return response()->json([
            "ok" => true,
            "message" => "correcto",
        ]);
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
     * @param  \App\Models\MensajeSala  $mensajeSala
     * @return \Illuminate\Http\Response
     */
    public function show(MensajeSala $mensajeSala)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MensajeSala  $mensajeSala
     * @return \Illuminate\Http\Response
     */
    public function edit(MensajeSala $mensajeSala)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MensajeSala  $mensajeSala
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MensajeSala $mensajeSala)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MensajeSala  $mensajeSala
     * @return \Illuminate\Http\Response
     */
    public function destroy(MensajeSala $mensajeSala)
    {
        //
    }
}
