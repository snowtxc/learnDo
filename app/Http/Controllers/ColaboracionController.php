<?php

namespace App\Http\Controllers;

use App\Models\colaboracion;
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
            $colabToSave = new colaboracion();
            $colabToSave->user_id = $colaborador['id'];
            $colabToSave->evento_id = $request->input('evento_id');
            $colabToSave->save();
        }

        return response()->json([
            'message' => 'Las colaboraciones fueron creadas exitosamente.',
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
    public function destroy(colaboracion $colaboracion)
    {
        //
    }
}