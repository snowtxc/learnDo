<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use App\Models\Curso;
use App\Models\Evento;
use App\Models\Modulo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Validator;

class ClaseController extends Controller
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

    // public function uploadFile(Request $request) {
    //     echo $path = $request->file('video')->storeAs(
    //         'videos', $request->image->getClientOriginalName()
    //     );
    // }
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'descripcion' => 'required',
            'video' => 'required|file',
            'estado' => 'required',
            'modulo_id' => 'required',
            'sugerencia_id' => '',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $description = $request->input('descripcion');
        $clase = new Clase();
        $clase->nombre = $request->input('nombre');
        if (isset($description)) {
            $clase->descripcion = $description;
        } else {
            $clase->descripcion = "";
        }
        $clase->estado = $request->input('estado');
        $clase->modulo_id = $request->input('modulo_id');
        $sugerencia = $request->input('sugerencia_id');
        if(isset($sugerencia)){
            $clase->sugerencia_id = $sugerencia;
        }
        $clase->save();

        return response()->json([
            'message' => 'La clase se ha creado correctamente.',
            'clase' => $clase,
        ], 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getClaseInfo(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'clase_id' => 'required|string',
                'curso_id' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors());
            }
            $cursoInfo = Curso::where("evento_id_of_curso", $request->curso_id)->first();
            if (!isset($cursoInfo)) {
                throw new Exception("Error al obtener el curso");
            }

            $eventoInfo = Evento::where("id", $request->curso_id)->first();
            if (!isset($eventoInfo)) {
                throw new Exception("Error al obtener el evento");
            }

            $meInfo = auth()->user();
            $myId = $meInfo->id;

            $esComprado = DB::table("compraevento")->where("evento_id", "=", $eventoInfo->id)
                ->where("estudiante_id", "=", $myId)->first();

            if (!isset($esComprado)) {
                throw new Exception("Permiso denegado");
            }

            $claseInfo = Clase::find($request->clase_id);
            if (!isset($claseInfo)) {
                throw new Exception("Error al obtener la clase");
            }
            $moduloInfo = Modulo::find($claseInfo->modulo_id);
            if (!isset($moduloInfo)) {
                throw new Exception("Error al obtener el modulo");
            }

            if ($moduloInfo->curso_id !== $cursoInfo->evento_id_of_curso) {
                throw new Exception("Error al obtener la informacion de la clase");
            }

            return response()->json([
                "ok" => true,
                "clase" => $claseInfo,
                "moduloName" => $moduloInfo->nombre,
                "cursoName" => $eventoInfo->nombre
            ]);

        } catch (\Throwable $th) {
                return response()->json([
                    "ok" => false,
                    "message" => $th->getMessage()
                ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Clase  $clase
     * @return \Illuminate\Http\Response
     */
    public function show(Clase $clase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Clase  $clase
     * @return \Illuminate\Http\Response
     */
    public function edit(Clase $clase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Clase  $clase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Clase $clase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Clase  $clase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Clase $clase)
    {
        //
    }
}