<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\SeminarioPresencial;
use App\Models\Usuario;
use Illuminate\Http\Request;
use App\Models\SeminarioVirtual;
use Validator;
use Illuminate\Support\Facades\DB;
use Exception;

class SeminarioPresencialController extends Controller
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
            'evento_id' => 'required',
            'nombre_ubicacion' => 'required',
            'latitud' => 'required',
            'longitud' => 'required',
            'maximo_participantes' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $seminario = new SeminarioPresencial();
        $seminario->evento_id = $request->input('evento_id');
        $seminario->nombre_ubicacion = $request->input('nombre_ubicacion');
        $seminario->latitud = $request->input('latitud');
        $seminario->longitud = $request->input('longitud');
        $seminario->maximo_participantes = $request->input('maximo_participantes');
        $seminario->save();

        return response()->json([
            'message' => 'El seminario se ha creado correctamente.',
            'curso' => $seminario,
        ], 201);
    }

    public function getCompleteInfoSeminario(Request $req)
    {
        try {
            $validator = Validator::make($req->all(), [
                "seminarioId" => "required",
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors());
            }
            $seminarioId = $req->seminarioId;

            $meInfo = auth()->user();
            $myId = $meInfo->id;
            $seminarioType = DB::table('eventos')
                ->select('eventos.tipo')
                ->where([["id", $seminarioId], ['tipo', '<>', 'curso']])->first();

                if (!isset($seminarioType)) {
                throw new Exception("Error, seminario not found.");
            }

            $seminarioInfo = null;
            if ($seminarioType->tipo === 'seminarioP') {
                $seminarioInfo = DB::table('eventos')
                    ->join('seminario_presencials', 'seminario_presencials.evento_id', '=', 'eventos.id')
                    ->select(
                        'eventos.id',
                        'eventos.nombre',
                        'eventos.imagen',
                        'eventos.descripcion',
                        'eventos.es_pago',
                        'eventos.precio',
                        'eventos.tipo',
                        'eventos.organizador_id',
                        'seminario_presencials.fecha',
                        'seminario_presencials.hora',
                        'seminario_presencials.duracion',
                        'seminario_presencials.maximo_participantes',
                        'seminario_presencials.latitud',
                        'seminario_presencials.longitud'
                    )
                    ->where("id", $seminarioId)->first();
            }
            if ($seminarioType->tipo === 'seminarioV') {
                $seminarioInfo = DB::table('eventos')
                    ->join('seminario_virtuals', 'seminario_virtuals.evento_id', '=', 'eventos.id')
                    ->select(
                        'eventos.id',
                        'eventos.nombre',
                        'eventos.imagen',
                        'eventos.descripcion',
                        'eventos.es_pago',
                        'eventos.precio',
                        'eventos.tipo',
                        'eventos.organizador_id',
                        'seminario_virtuals.fecha',
                        'seminario_virtuals.hora',
                        'seminario_virtuals.duracion',
                        'seminario_virtuals.link',
                        'seminario_virtuals.estado',
                    )
                    ->where("id", $seminarioId)->first();
            }
            if (!isset($seminarioInfo)) {
                throw new Exception("Error al obtener la informacion del seminario");
            }

            $organizadorInfo = Usuario::where("id", $seminarioInfo->organizador_id)->first();
            $categorias = DB::table('categoriaeventos')
                ->join('categorias', 'categoriaeventos.categoria_id', '=', 'categorias.id')
                ->select('categorias.nombre', 'categorias.id')
                ->where("categoriaeventos.evento_id", $seminarioId)->get();

            $esComprado = DB::table("compraevento")->where("evento_id", "=", $seminarioId)
                ->where("estudiante_id", "=", $myId)->first();

            return response()->json([
                "ok" => true,
                "seminario" => $seminarioInfo,
                "categorias" => $categorias,
                "comprado" => isset($esComprado),
                "profesor" => $organizadorInfo->nombre,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "ok" => false,
                "message" => $th->getMessage(),
            ]);
        }
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function listarSeminariosPresenciales(Request $request)
    {
        try {
            $seminarios = SeminarioPresencial::all();
            $formattedSeminarios = array();
            foreach ($seminarios as $seminario) {
                $eventoInfo = Evento::find($seminario->evento_id);
                $newItem = [
                    "latitud" => $seminario->latitud,
                    "longitud" => $seminario->longitud,
                    "fecha" => $seminario->fecha,
                    "hora" => $seminario->hora,
                    "duracion" => $seminario->duracion,
                    "maximo_participantes" => $seminario->maximo_participantes,
                    "imagen" => $eventoInfo->imagen,
                    "precio" => $eventoInfo->precio,
                    "nombre" => $eventoInfo->nombre,
                    "descripcion" => $eventoInfo->descripcion,
                ];
                array_push($formattedSeminarios, $newItem);
            }

            return response()->json([
                "ok" => true,
                "seminarios" => $formattedSeminarios,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "ok" => false,
                "message" => $th->getMessage(),
            ]);
        }
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
     * @param  \App\Models\SeminarioPresencial  $seminarioPresencial
     * @return \Illuminate\Http\Response
     */
    public function show(SeminarioPresencial $seminarioPresencial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SeminarioPresencial  $seminarioPresencial
     * @return \Illuminate\Http\Response
     */
    public function edit(SeminarioPresencial $seminarioPresencial)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SeminarioPresencial  $seminarioPresencial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SeminarioPresencial $seminarioPresencial)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SeminarioPresencial  $seminarioPresencial
     * @return \Illuminate\Http\Response
     */
    public function destroy(SeminarioPresencial $seminarioPresencial)
    {
        //
    }
}