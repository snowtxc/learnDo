<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Usuario;

use Illuminate\Http\Request;

class EventoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     
    public function listar(Request $request)
    {
        $page =  ($request->query('page') != null && $request->query('page') >= 1) ? $request->query('page') :  1;  
        $maxRows =  $request->query('maxRows') != null ? $request->query('maxRows') : 10;  
        $offset = $page == 1 ? 0 :  (($page - 1) * $maxRows);  
        $categoriaFilterIds =$request->query('categoria') != null ? $request->query('categoria') : null; //array con las categorias a filtrar
        $tipoFilter  = $request->query('categoria') != null ? $request->query('tipo') : null;

        $eventos = Evento::whereHas('categorias', function($query) use ($categoriaFilterIds) {
            if($categoriaFilterIds != null){
                $query->whereIn('categorias.id', $categoriaFilterIds);  
            }
           
        })->skip($offset)->take($maxRows)->get();
        
        $result =  array();
        foreach($eventos as $evento){
            $organizadorID =  $evento['organizador_id'];
            $organizadorData = Usuario::find($organizadorID);

            $extraData = array(
                "organizador" => $organizadorData,
                "categorias" => $evento->categorias);

            $data = array_merge($evento->toArray(), $extraData);  //merge data and retrieve a new result
            array_push($result,$data);
        }
        return response()->json([ "result" => $result]);  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\Models\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function show(Evento $evento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function edit(Evento $evento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Evento $evento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Evento $evento)
    {
        //
    }
}
