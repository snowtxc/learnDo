<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

use Validator;

class CategoriaController extends Controller
{
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
        
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        try{
            $nombre = $request->input('nombre'); 
            $newCategory = new Categoria();
            $newCategory->nombre = $nombre;
            $newCategory->save(); 
            return response()->json($newCategory,201);  
        }catch(Exception $e){
            return response()->json(["message" => "Ha ocurrido un error inesperado"] ,500);   
        }
          
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function getAll(Request $request)
    {
     
        try{
            $categorias =  Categoria::all();
            return response()->json($categorias); 
        }catch(Exception $e){
            return response()->json(["message" => "Ha ocurrido un error inesperado"] ,500); 
        }
      
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    { 
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
         try{
            $categoria = Categoria::find($id);
            if(empty($categoria)){
                return response()->json(["message" => "Categoria no existe"] ,404);  
            } 
            $categoria->nombre = $request->input('nombre');
            $categoria->save();
            return response()->json($categoria); 
        }catch(Exception $e){
            return response()->json(["message" => "Ha ocurrido un error inesperado"] ,500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        try{
            $categoria = Categoria::find($id);
            if(empty($categoria)){
                return response()->json(["message" => "Categoria no existe"] ,404);  
            } 
            $categoria->delete();
            return response()->json($categoria); 
        }catch(Exception $e){
            return response()->json(["message" => "Ha ocurrido un error inesperado"] ,500);
        }
    }
}
