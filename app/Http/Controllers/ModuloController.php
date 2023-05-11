<?php

namespace App\Http\Controllers;

use App\Models\Modulo;
use App\Models\Evento;
use Illuminate\Http\Request;
use Validator;


/*
Route::get('/listByEventoId/{$eventoId}', [ModuloController::class, "listByEventoId"]);
Route::put('/{id}', [ModuloController::class, "update"]);*/

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
            'evento_id' => 'required',
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
        $evento = Evento::find($request->input('evento_id')); 
        if(empty($evento)){
            return response()->json(["message" => "Evento no existe"] ,404);  
        }  
        $modulo = new Modulo();
        $modulo->nombre = $request->input('nombre');
        $modulo->estado = $request->input('estado');
        $modulo->curso_id = $request->input('evento_id');
        $modulo->save();

        return response()->json([
            'message' => 'El modulo se ha creado correctamente',
            'modulo' => $modulo,
        ], 201);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Modulo  $modulo
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        try{
            $modulo= Modulo::find($id);
            if(empty($modulo)){
                return response()->json(["message" => "Modulo no existe"] ,404);  
            }  
            return response()->json($modulo);
        }catch(Exception $e){
            return response()->json(["message" => "Ha ocurrido un error inesperado"] ,500);
        }
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Modulo  $modulo
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nombre' => 'required',
            'estado' => 'required',
            'evento_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
          
        try{
            $evento = Evento::find($request->input('evento_id'));
            if(empty($evento)){
                return response()->json(["message" => "Evento no existe"] ,404);  
            }  
            $modulo= Modulo::find($id);
            if(empty($modulo)){
                return response()->json(["message" => "Modulo no existe"] ,404);  
            }  
            $modulo->nombre = $request->input('nombre');
            $modulo->estado = $request->input('estado');
            $modulo->curso_id = $request->input('evento_id');

            $modulo->save();
            
            return response()->json($modulo);

            
        }catch(Exception $e){
            return response()->json(["message" => "Ha ocurrido un error inesperado"] ,500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Modulo  $modulo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $modulo = Modulo::find($id);
            if(empty($modulo)){
                return response()->json(["message" => "Modulo no existe"] ,404);  
            } 
            $modulo->delete();
            return response()->json($modulo); 
        }catch(Exception $e){
            return response()->json(["message" => "Ha ocurrido un error inesperado"] ,500);
        }
    }

    public function listByEventoId($eventoId)
    {
        $evento = Evento::find($eventoId); 
        if(empty($evento)){
            return response()->json(["message" => "Evento no existe"] ,404);  
        }  
        $modulo = Modulo::where("curso_id", "=", $eventoId)->get();
        return response()->json($modulo); 

    }
}
