<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Publicacion;
use App\Models\CompraEvento;
use App\Models\Evento;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class ComentarioController extends Controller
{

    public function __construct() {
        $this->middleware('jwt');
    }

    
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
       
        try{
            $validator = Validator::make($request->all(),[
                'contenido' => 'required',
                'publicacionId' => 'required'
            ]);   
            if ($validator->fails()) {
                return response()->json($validator->errors());
            }
            $publicacion = Publicacion::find($request->input('publicacionId'));
            if(!isset($publicacion)){
                return response()->json(["message" => "La publicacion no existe"] ,404);
            }
            $foro =  $publicacion->foro;
            $cursoId = $foro->id_curso;
            $userInfo = auth()->user();
            $userId  = $userInfo["id"];
    
            $userAlreadyHasEvento = CompraEvento::where(["evento_id" => $cursoId, "estudiante_id" => $userId])->count() > 0 ? true : false; //check if user is student of event
            $userIsOwner =  Evento::where(["id" => $cursoId, "organizador_id" => $userId])->count() > 0 ? true : false;  //check if user is owner of event
    
            if(!$userAlreadyHasEvento && !$userIsOwner){
                return response()->json(["message" => "No perteneces al curso ya que no eres estudiante ni organizador."] ,400);
            }
    
            $newComment = new Comentario();
            $newComment->contenido = $request->input("contenido");
            $newComment->publicacion_id = $request->input("publicacionId");
            $newComment->user_id = $userId;
            

            $newComment->save();

            $result = [
                "id"  => $newComment->id,
                "user" => $newComment->user,
                "contenido" => $newComment->contenido,
                "enableDelete" => true
            ];

            return response()->json($result);

        }catch(Exception $e){
            return response()->json(["message" => "Ha ocurrido un error inesperado"] ,500);


        }
    }

   

   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comentario  $comentario
     * @return \Illuminate\Http\Response
     */
    public function edit($id,Request $request)
    {
        try{
            $validator = Validator::make($request->all(),[
                'contenido' => 'required'
            ]);   
            if ($validator->fails()) {
                return response()->json($validator->errors());
            }
            $comment = Comentario::find($id);
            if(!isset($comment)){
                return response()->json(["message" => "El comentario no existe"] ,404);
            }
            $userInfo = auth()->user();
            $userId  = $userInfo["id"];

            if($comment->user_id != $userId){
                return response()->json(["message" => "No puedes editar la publicacion por que no eres dueño"] ,404);
            }

            $comment->update(["contenido" => $request->input("contenido")]);

            return response()->json($comment);
        }catch(Exception $e){
            return response()->json(["message" => "Ha ocurrido un error inesperado"] ,500);

        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comentario  $comentario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comentario $comentario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comentario  $comentario
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            
            $comment = Comentario::find($id);
            if(!isset($comment)){
                return response()->json(["message" => "El comentario no existe"] ,404);
            }
            $userInfo = auth()->user();
            $userId  = $userInfo["id"];
            $post = $comment->publicacion;
            $foro = $post->foro;
            $cursoId = $foro->id_curso;

            $userIsCourseOwner =  Evento::where(["id" => $cursoId, "organizador_id" => $userId])->count() > 0 ? true : false;  //check if user is owner of event

            if($comment->user_id != $userId && !$userIsCourseOwner){
                return response()->json(["message" => "No puedes eliminar este comentario por que no eres propietario ni administrador del curso"] ,404);
            }

            $comment->delete();
            return response()->json(["message" => "Comentario eliminado correctamente"] ,200);
        }catch(Exception $e){
            return response()->json(["message" => "Ha ocurrido un error inesperado"] ,500);

        }
    }


    function listByPublicacionId($publicacionId){
        try{
            $comments = Comentario::where("publicacion_id", "=", $publicacionId)->orderBy("created_at","DESC")->get();
            $result = array();

            $userInfo = auth()->user();
            $userId  = $userInfo["id"];

            $userIsEventoOwner = Evento::find(Publicacion::find($publicacionId)->foro->id_curso)->organizador_id == $userId ? true : false;

            
            foreach($comments as $comment){
               $userData = $comment->user;
               unset($userData->password);
               
               $userIsCommentOwner = $comment->user_id == $userId ? true : false;
               $data = array(
                "id" => $comment->id,
                "contenido" => $comment->contenido,
                "created_at" => $comment->created_at,
                "user" => $comment->user,
                "enableDelete" => ($userIsEventoOwner || $userIsCommentOwner) ,
                "publicacion_id" => $comment->publicacion_id
               );

               array_push($result,$data);
            }
            return response()->json($result);
        }catch(Exception $e){
            return response()->json(["message" => "Ha ocurrido un error inesperado"] ,500);
        }
      
    }
   

    
}
