<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;

class CursoController extends Controller
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

    public function getInfoCurso(Request $req) {
        $validator = Validator::make($req->all(),[
            "id" => "required|string",
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $curso = DB::table('eventos')
        ->join('cursos', 'cursos.evento_id', '=', 'eventos.id')
        ->select('eventos.id', 'eventos.nombre', 'eventos.descripcion', 'eventos.es_pago', 'eventos.precio', 'eventos.organizador_id', 'eventos.categoria_id', 'cursos.porcentaje_aprobacion', 'cursos.ganancias_acumuladas')
        ->where("evento_id", $req->id)->first();

        if (!isset($curso)){
            return response([], 404);
        }

        return response()->json($curso, 200);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'porcentaje_aprobacion' => '',
            'ganancias' => '',
            'evento_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $curso = new Curso();
        $curso->porcentaje_aprobacion = $request->input('porcentaje_aprobacion');
        $curso->ganancias_acumuladas = $request->input('ganancias');
        $curso->evento_id = $request->input('evento_id');
        $curso->save();
        
        return response()->json([
            'message' => 'El curso se ha creado correctamente.',
            'curso' => $curso,
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
     * @param  \App\Models\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function show(Curso $curso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function edit(Curso $curso)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Curso $curso)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function destroy(Curso $curso)
    {
        //
    }
}
