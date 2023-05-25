<?php

namespace App\Http\Controllers;

use App\Models\Publicacion;
use App\Models\Curso;

use App\Models\CompraEvento;
use App\Models\Evento;
use App\Models\Foro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Validator;
class PublicacionController extends Controller
{

    public function __construct() {
        $this->middleware('jwt');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        try{
            $validator = Validator::make($request->all(),[
                'nombre' => 'required',
                'contenido' => 'required',
                'foroId' => 'required'
            ]);   
    
            if ($validator->fails()) {
                return response()->json($validator->errors());
            }
            $foro = Foro::find($request->input('foroId'));
            if(!isset($foro)){
                return response()->json(["message" => "El foro no existe"] ,404);
            }
            $cursoId = $foro->id_curso;
            $userInfo = auth()->user();
            $userId  = $userInfo["id"];
    
            $userAlreadyHasEvento = CompraEvento::where(["evento_id" => $cursoId, "estudiante_id" => $userId])->count() > 0 ? true : false; //check if user is student of event
            $userIsOwner =  Evento::where(["id" => $cursoId, "organizador_id" => $userId])->count() > 0 ? true : false;  //check if user is owner of event
    
            if(!$userAlreadyHasEvento && !$userIsOwner){
                return response()->json(["message" => "No perteneces al curso ya que no eres estudiante ni organizador."] ,400);
            }
    
            $newPost = new Publicacion();
            $newPost->nombre = $request->input("nombre");
            $newPost->contenido = $request->input("contenido");
            $newPost->foro_id = $request->input("foroId");
            $newPost->user_id = $userId;

            $newPost->save();

            return response()->json($newPost);

        }catch(Exception $e){
            return response()->json(["message" => "Ha ocurrido un error inesperado"] ,500);


        }
       

    }

   
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Publicacion  $publicacion
     * @return \Illuminate\Http\Response
     */
    public function show(Publicacion $publicacion)
    {
        //muestre los comentarios asociados
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Publicacion  $publicacion
     * @return \Illuminate\Http\Response
     */
    public function edit($id,Request $request)
    {
        try{
            $validator = Validator::make($request->all(),[
                'nombre' => 'required',
                'contenido' => 'required'
            ]);   
            if ($validator->fails()) {
                return response()->json($validator->errors());
            }
            $publicacion = Publicacion::find($id);
            if(!isset($publicacion)){
                return response()->json(["message" => "La publicacion no existe"] ,404);
            }
            $publicacion->update(["nombre" => $request->input("nombre"), "contenido" => $request->input("contenido")]);

            return response()->json($publicacion);
        }catch(Exception $e){
            return response()->json(["message" => "Ha ocurrido un error inesperado"] ,500);

        }
        
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Publicacion  $publicacion
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        try{
            
            $publicacion = Publicacion::find($id);
            if(!isset($publicacion)){
                return response()->json(["message" => "La publicacion no existe"] ,404);
            }
            $publicacion->delete();
            return response()->json($publicacion);
        }catch(Exception $e){
            return response()->json(["message" => "Ha ocurrido un error inesperado"] ,500);

        }
    }
}
