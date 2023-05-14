<?php

namespace App\Http\Controllers;

use App\Models\SeminarioVirtual;
use Illuminate\Http\Request;
use Validator;

class SeminarioVirtualController extends Controller
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
            'evento_id' => 'required',
            'nombre_plataforma' => 'required',
            'estado' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $seminario = new SeminarioVirtual();
        $seminario->evento_id = $request->input('evento_id');
        $seminario->nombre_plataforma = $request->input('nombre_plataforma');
        $seminario->estado = $request->input('estado');
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SeminarioVirtual  $seminarioVirtual
     * @return \Illuminate\Http\Response
     */
    public function show(SeminarioVirtual $seminarioVirtual)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SeminarioVirtual  $seminarioVirtual
     * @return \Illuminate\Http\Response
     */
    public function edit(SeminarioVirtual $seminarioVirtual)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SeminarioVirtual  $seminarioVirtual
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SeminarioVirtual $seminarioVirtual)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SeminarioVirtual  $seminarioVirtual
     * @return \Illuminate\Http\Response
     */
    public function destroy(SeminarioVirtual $seminarioVirtual)
    {
        //
    }
}
