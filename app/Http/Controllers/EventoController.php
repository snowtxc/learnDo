<?php

namespace App\Http\Controllers;

use App\Http\Utils\CursoUtils;
use App\Models\CompraEvento;
use App\Models\Evento;
use App\Models\Usuario;
use App\Models\Curso;
use App\Models\SeminarioPresencial;
use App\Models\SeminarioVirtual;
use App\Models\Foro;
use App\Models\Certificado;
use App\Models\Organizador;

use Spatie\GoogleCalendar\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


use Exception;
use Illuminate\Http\Request;

use App\Http\Controllers\ModuloController;
use App\Models\categoriaevento;
use Validator;

class EventoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('jwt');
    }


    public function comprarEvento(Request $req)
    {
        try {
            $uid = $req->uid;
            $eventoId = $req->eventoId;
            $monto = $req->monto;
            $metodoPago = $req->metodoPago;
            $useDiscount = $req->useDiscount;
            if (!isset($uid) || !isset($metodoPago) || !isset($monto) || !isset($eventoId)) {
                throw new Exception("Datos invalidos");
            }
            $compraEvento = CompraEvento::where("estudiante_id", "=", $uid)->where("evento_id", "=", $eventoId)->first();

            if (!isset($compraEvento)) {
                $userInfo = Usuario::find($uid);
                $eventoInfo = Evento::find($eventoId);
                if (!isset($userInfo) || !isset($eventoInfo)) {
                    throw new Exception("Usuario o evento invalido");
                }
                if ($userInfo->type == "organizador") {
                    throw new Exception("Los organizadores no pueden comprar eventos");
                }

                if ($useDiscount) {
                    Usuario::where("id", "=", $uid)->update([
                        "creditos_number" => $userInfo->creditos_number -= 10
                    ]);
                }

                $existsSeminarioPresencial = SeminarioPresencial::where("evento_id", $eventoId)->first();
                $existsSeminarioVirtual = SeminarioVirtual::where("evento_id", $eventoId)->first();

                $isSeminario = isset($existsSeminarioPresencial) || isset($existsSeminarioVirtual);

                if ($isSeminario == true) {
                    $gcc = new GoogleCalendarController();

                    // if (isset($existsSeminarioPresencial)) {
                    //     $gcc->MakeEvent(
                    //         $existsSeminarioPresencial->fecha,
                    //         $existsSeminarioPresencial->hora,
                    //         $existsSeminarioPresencial->duracion,
                    //         $userInfo->email,
                    //         $eventoInfo->nombre,
                    //         $eventoInfo->descripcion,
                    //     );
                    // } else if (isset($existsSeminarioVirtual)) {
                    //     $gcc->MakeEvent(
                    //         $existsSeminarioVirtual->fecha,
                    //         $existsSeminarioVirtual->hora,
                    //         $existsSeminarioVirtual->duracion,
                    //         $userInfo->email,
                    //         $eventoInfo->nombre,
                    //         $eventoInfo->descripcion,
                    //     );
                    // }

                }
                $buyedEvent = new CompraEvento();
                $buyedEvent->estudiante_id = $uid;
                $buyedEvent->evento_id = $eventoId;
                $buyedEvent->metodoPago = $metodoPago;
                $buyedEvent->monto = $monto;
                $buyedEvent->save();

            }

            return response()->json([
                "ok" => true,
                "message" => "Evento comprado correctamente"
            ]);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                "ok" => false,
                "message" => $th->getMessage()
            ], 400);
        }
    }


    public function listar(Request $request)
    {

        $page = ($request->query('page') != null && $request->query('page') >= 1) ? $request->query('page') : 1;
        $maxRows = $request->query('maxRows') != null ? $request->query('maxRows') : 10;
        $offset = $page == 1 ? 0 : (($page - 1) * $maxRows);
        $categoriaFilterIds = $request->query('categoria') != null ? $request->query('categoria') : null; //array con las categorias a filtrar
        $busqueda = ($request->query('busqueda') != null && $request->query('busqueda') != '') ? $request->query('busqueda') : null; //array con las categorias a filtrar

        $tipo = $request->query('tipo') != null ? $request->query('tipo') : null;

        $eventos = Evento::whereHas('categorias', function ($query) use ($categoriaFilterIds) {
            if ($categoriaFilterIds != null) {
                $query->whereIn('categorias.id', $categoriaFilterIds);
            }

        })->when(isset($busqueda), function ($query) use ($busqueda) {
            $query->where('nombre', 'like', '%' . $busqueda . '%');
        })->when(isset($tipo), function ($query) use ($tipo) {


            $query->where("tipo", "=", $tipo);
        })
            ->skip($offset)->take($maxRows)->get();


        //Queda hacer un filtro por tipo/

        $result = array();
        foreach ($eventos as $evento) {
            $organizadorID = $evento['organizador_id'];
            $organizadorData = Usuario::find($organizadorID);

            $extraData = array(
                "organizador" => $organizadorData,
                "categorias" => $evento->categorias
            );

            $data = array_merge($evento->toArray(), $extraData); //merge data and retrieve a new result
            array_push($result, $data);
        }
        return response()->json(["result" => $result, "categoriasIds" => $categoriaFilterIds]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string',
            'descripcion' => 'required|string',
            'imagen' => 'required|string',
            'es_pago' => 'required|boolean',
            'precio' => 'required_if:es_pago,true',
            'organizador' => 'required',
            'porcentaje_aprobacion' => 'required_if:tipo,curso',
            'tipo' => 'required|in:curso,seminarioV,seminarioP',
            // 'nombre_foro' => 'required_if:tipo,curso',
            'nombre_ubicacion' => 'required_if:tipo,seminarioP',
            'latitud' => 'required_if:tipo,seminarioP',
            'longitud' => 'required_if:tipo,seminarioP',
            'duracion' => 'required_if:tipo,seminarioP,seminarioV',
            'maximo_participantes' => 'required_if:tipo,seminarioP',
            // 'nombre_plataforma' => 'required_if:tipo,seminarioV',
            'estado' => 'string',
            'fecha' => 'string',
            'hora' => 'string',
            'link' => 'required_if:tipo,seminarioV',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $evento = new Evento();
        $evento->nombre = $request->input('nombre');
        $evento->descripcion = $request->input('descripcion');
        $evento->imagen = $request->input('imagen');
        $evento->es_pago = $request->input('es_pago');
        $evento->precio = $request->input('precio');
        $evento->organizador_id = $request->input('organizador');
        $evento->tipo = $request->input('tipo');
        // $evento->categoria_id  = $request->input('categoria');
        $evento->save();

        $categorias = $request->categorias ? $request->categorias : array();

        foreach ($categorias as $categoria) {
            $categoriaEvento = new categoriaevento();
            $categoriaEvento->evento_id = $evento->id;
            $categoriaEvento->categoria_id = $categoria;
            $categoriaEvento->save();
        }

        if ($request->tipo === 'curso') {
            $curso = new Curso();
            $curso->evento_id_of_curso = $evento->id;
            $curso->porcentaje_aprobacion = $request->input('porcentaje_aprobacion');
            $curso->save();

            $foro = new Foro();
            $foro->nombre = $request->nombre;
            $foro->id_curso = $evento->id;
            $foro->save();

        } else if ($request->tipo === 'seminarioV') {
            $seminarioV = new SeminarioVirtual();
            $seminarioV->evento_id = $evento->id;
            $seminarioV->nombre_plataforma = $request->nombre;
            $seminarioV->hora = $request->hora;
            $seminarioV->fecha = $request->fecha;
            $seminarioV->duracion = $request->duracion;
            $seminarioV->link = $request->link;
            if (isset($request->estado)) {
                $seminarioV->estado = $request->estado;
            } else {
                $seminarioV->estado = "NotLive";
            }
            $seminarioV->save();
        } else if ($request->tipo === 'seminarioP') {
            $seminarioP = new SeminarioPresencial();
            $seminarioP->evento_id = $evento->id;
            $seminarioP->hora = $request->hora;
            $seminarioP->fecha = $request->fecha;
            $seminarioP->nombre_ubicacion = $request->nombre_ubicacion;
            $seminarioP->latitud = $request->latitud;
            $seminarioP->duracion = $request->duracion;
            $seminarioP->longitud = $request->longitud;
            $seminarioP->maximo_participantes = $request->maximo_participantes;
            $seminarioP->save();
        }

        return response()->json([
            'message' => 'El evento se ha creado correctamente.',
            'evento' => $evento,
        ], 201);
    }


    public function userIsStudentOrOwner($eventoID, Request $req)
    {
        try {
            $userInfo = auth()->user();
            $userId = $userInfo["id"];

            $eventoInfo = Evento::find($eventoID);
            if (!isset($eventoInfo)) {
                return response()->json(["message" => "El evento no existe"], 404);
            }
            $userAlreadyHasEvento = CompraEvento::where(["evento_id" => $eventoID, "estudiante_id" => $userId])->count() > 0 ? true : false; //check if user is student of event
            $userIsOwner = Evento::where(["id" => $eventoID, "organizador_id" => $userId])->count() > 0 ? true : false; //check if user is owner of event
            return response()->json(["result" => $userAlreadyHasEvento || $userIsOwner], 200);

        } catch (Exception $e) {
            return response()->json(["message" => "Ha ocurrido un error inesperado"], 500);

        }

    }

    public function getMyEventos(Request $req)
    {
        try {

            $userInfo = auth()->user();
            $userId  = $userInfo["id"];
           

            $misEventos = DB::table("eventos")->join('compraevento', 'compraevento.evento_id', '=', 'eventos.id')->where("compraevento.estudiante_id", $userId)->select("eventos.id","eventos.tipo")->get();
           
            $result = array();

            if (isset($misEventos) && sizeof($misEventos) > 0) {
                foreach ($misEventos as $miEvento) {
                    // echo var_dump($miEvento);
                    if ($miEvento->tipo === "curso") {

                        $cursoInfo = DB::table('cursos')
                            ->join('eventos', 'cursos.evento_id_of_curso', '=', 'eventos.id')
                            ->select(
                                'eventos.id',
                                'eventos.nombre',
                                'eventos.descripcion',
                                'eventos.imagen',
                                'eventos.es_pago',
                                'eventos.precio',
                                'eventos.organizador_id',
                                'eventos.tipo',
                                'cursos.porcentaje_aprobacion'
                            )
                            ->where("cursos.evento_id_of_curso", $miEvento->id)->first();



                        $cursoUtils = new CursoUtils();
                        $calificacionCurso = $cursoUtils->calificacionesOfCurso($miEvento->id);
                        $averageCalificaciones = $calificacionCurso["averageCalificaciones"];
                        $countPuntuaciones = $calificacionCurso["countPuntuaciones"];
                        $countEstudiantes = $calificacionCurso["countEstudiantes"];

                        if (isset($cursoInfo)) {
                            $cursoInfo->stars = $averageCalificaciones;
                            $cursoInfo->countPuntuaciones = $countPuntuaciones;
                            $cursoInfo->countEstudiantes = $countEstudiantes;
                            $certificate = Certificado::where(["estudiante_id" => $userId, "curso_id" => $cursoInfo->id])->first();
                            $cursoInfo->certificateID = $certificate != null ? $certificate->id : null;
                            $cursoInfo->porcentajeCurso = $cursoUtils->canStudentGetCertificate($userId, $cursoInfo->id, $cursoInfo->porcentaje_aprobacion)["avgCalifications"];

                            array_push($result, $cursoInfo);

                        }

                    }

                    if ($miEvento->tipo === "seminarioP") {
                        $seminarioPInfo = DB::table('seminario_presencials')
                            ->join('eventos', 'seminario_presencials.evento_id', '=', 'eventos.id')
                            ->select(
                                'eventos.id',
                                'eventos.nombre',
                                'eventos.descripcion',
                                'eventos.imagen',
                                'eventos.es_pago',
                                'eventos.precio',
                                'eventos.organizador_id',
                                'eventos.tipo',
                            )
                            ->where("seminario_presencials.evento_id", $miEvento->id)->first();

                        if (isset($seminarioPInfo)) {
                            array_push($result, $seminarioPInfo);
                        }
                    }

                    if ($miEvento->tipo === "seminarioV") {
                        $seminarioVInfo = DB::table('seminario_virtuals')
                            ->join('eventos', 'seminario_virtuals.evento_id', '=', 'eventos.id')
                            ->select(
                                'eventos.id',
                                'eventos.nombre',
                                'eventos.descripcion',
                                'eventos.imagen',
                                'eventos.es_pago',
                                'eventos.precio',
                                'eventos.organizador_id',
                                'eventos.tipo',
                            )
                            ->where("seminario_virtuals.evento_id", $miEvento->id)->first();
                        if (isset($seminariosVInfo)) {
                            array_push($result, $seminarioVInfo);
                        }
                    }
                }
            }

            return response()->json(["eventos" => $result], 200);

        } catch (Throwable $th) {
            return response()->json([
                "ok" => false,
                "message" => $th->getMessage()
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

    public function getEventosAdmin(Request $req)
    {
        try {
            $validator = Validator::make($req->all(), [
                "organizadorId" => "required|string",
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors());
            }
            $organizadorInfo = Organizador::where("user_id", "=", $req->organizadorId)->first();
            if (!isset($organizadorInfo)) {
                throw new Exception("El organizador no existe");
            }
            $misEventos = DB::table("eventos")->where("organizador_id", "=", $req->organizadorId)->get();
            $cursos = array();
            $seminariosP = array();
            $seminariosV = array();

            if (isset($misEventos) && sizeof($misEventos) > 0) {
                foreach ($misEventos as $miEvento) {
                    // echo var_dump($miEvento);
                    if ($miEvento->tipo === "curso") {
                        $cursoInfo = DB::table('cursos')
                            ->join('eventos', 'cursos.evento_id_of_curso', '=', 'eventos.id')
                            ->select(
                                'eventos.id',
                                'eventos.nombre',
                                'eventos.descripcion',
                                'eventos.imagen',
                                'eventos.es_pago',
                                'eventos.precio',
                                'eventos.organizador_id',
                                'eventos.tipo',
                            )
                            ->where("cursos.evento_id_of_curso", $miEvento->id)->first();
                        $cursoUtils = new CursoUtils();
                        $calificacionCurso = $cursoUtils->calificacionesOfCurso($miEvento->id);
                        $averageCalificaciones = $calificacionCurso["averageCalificaciones"];
                        $countPuntuaciones = $calificacionCurso["countPuntuaciones"];
                        $countEstudiantes = $calificacionCurso["countEstudiantes"];

                        if (isset($cursoInfo)) {
                            $cursoInfo->stars = $averageCalificaciones;
                            $cursoInfo->countPuntuaciones = $countPuntuaciones;
                            $cursoInfo->countEstudiantes = $countEstudiantes;
                            array_push($cursos, $cursoInfo);
                        }
                    }

                    if ($miEvento->tipo === "seminarioP") {
                        $cursoInfo = DB::table('seminario_presencials')
                            ->join('eventos', 'seminario_presencials.evento_id', '=', 'eventos.id')
                            ->select(
                                'eventos.id',
                                'eventos.nombre',
                                'eventos.descripcion',
                                'eventos.imagen',
                                'eventos.es_pago',
                                'eventos.precio',
                                'eventos.organizador_id',
                                'eventos.tipo',
                            )
                            ->where("seminario_presencials.evento_id", $miEvento->id)->first();

                        if (isset($cursoInfo)) {
                            array_push($seminariosP, $cursoInfo);
                        }
                    }

                    if ($miEvento->tipo === "seminarioV") {
                        $cursoInfo = DB::table('seminario_virtuals')
                            ->join('eventos', 'seminario_virtuals.evento_id', '=', 'eventos.id')
                            ->select(
                                'eventos.id',
                                'eventos.nombre',
                                'eventos.descripcion',
                                'eventos.imagen',
                                'eventos.es_pago',
                                'eventos.precio',
                                'eventos.organizador_id',
                                'eventos.tipo',
                            )
                            ->where("seminario_virtuals.evento_id", $miEvento->id)->first();
                        if (isset($cursoInfo)) {
                            array_push($seminariosV, $cursoInfo);
                        }
                    }
                }
            }

            return response()->json([
                "ok" => true,
                "cursos" => $cursos,
                "seminariosP" => $seminariosP,
                "seminariosV" => $seminariosV,
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                "ok" => false,
                "message" => $th->getMessage()
            ]);
        }
    }

    public function listarTendencias(Request $req)

    {
        try {
            $cursosMasComprados = DB::table('compraevento')
                ->join('eventos', 'compraevento.evento_id', '=', 'eventos.id')
                ->select(
                    'eventos.id',
                    'eventos.nombre',
                    'eventos.descripcion',
                    'eventos.imagen',
                    'eventos.es_pago',
                    'eventos.precio',
                    'eventos.organizador_id',
                    'eventos.tipo',
                )
                ->where("eventos.tipo", "=", "curso")
                ->groupBy("compraevento.evento_id", "eventos.id", "eventos.nombre", "eventos.descripcion", "eventos.imagen", "eventos.es_pago", "eventos.precio", "eventos.organizador_id", "eventos.tipo")
                ->orderByDesc(DB::raw('count(compraevento.id)'))
                ->limit(10)
            ->get();

            if(sizeof($cursosMasComprados) < 1){ // en caso de que no hayan compras, simplemente traigo 10 cursos random.
                $cursosMasComprados = DB::table('eventos')
                ->select(
                    'eventos.id',
                    'eventos.nombre',
                    'eventos.descripcion',
                    'eventos.imagen',
                    'eventos.es_pago',
                    'eventos.precio',
                    'eventos.organizador_id',
                    'eventos.tipo',
                )
                ->where("eventos.tipo", "=", "curso")
                ->limit(10)
                ->get();
            }
            $cursosRecientes = DB::table('eventos')
            ->select(
                'eventos.id',
                'eventos.nombre',
                'eventos.descripcion',
                'eventos.imagen',
                'eventos.es_pago',
                'eventos.precio',
                'eventos.organizador_id',
                'eventos.tipo',
            )
            ->where("eventos.tipo", "=", "curso")
            ->orderByDesc('eventos.created_at')
            ->limit(10)
            ->get();

            $seminariosRandom = DB::table('eventos')
            ->select(
                'eventos.id',
                'eventos.nombre',
                'eventos.descripcion',
                'eventos.imagen',
                'eventos.es_pago',
                'eventos.precio',
                'eventos.organizador_id',
                'eventos.tipo',
            )
            ->where("tipo", "=", "seminarioP")
            ->orWhere("tipo", "=", "seminarioV")
            ->limit(5)
            ->get();

            return response()->json([
                "ok" => true,
                "eventosMasComprados" => $cursosMasComprados,
                "cursosRecientes" => $cursosRecientes,
                "seminariosRandom" => $seminariosRandom,
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
