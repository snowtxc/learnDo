<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Usuario;
use App\Models\Curso;
use App\Models\SeminarioPresencial;
use App\Models\SeminarioVirtual;
use App\Models\Foro;

use Illuminate\Http\Request;

use App\Http\Controllers\ModuloController;
use Validator;

class EventoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function listar(Request $request)
    {

        $page = ($request->query('page') != null && $request->query('page') >= 1) ? $request->query('page') : 1;
        $maxRows = $request->query('maxRows') != null ? $request->query('maxRows') : 10;
        $offset = $page == 1 ? 0 : (($page - 1) * $maxRows);
        $categoriaFilterIds = $request->query('categoria') != null ? $request->query('categoria') : null; //array con las categorias a filtrar
        $busqueda = ($request->query('busqueda') != null && $request->query('busqueda') != '') ? $request->query('busqueda') : null; //array con las categorias a filtrar


        $tipoFilter = $request->query('categoria') != null ? $request->query('tipo') : null;


        $eventos = Evento::whereHas('categorias', function ($query) use ($categoriaFilterIds) {
            if ($categoriaFilterIds != null) {
                $query->whereIn('categorias.id', $categoriaFilterIds);
            }

        })->when(isset($busqueda), function ($query) use ($busqueda) {
            $query->where('nombre', 'like', '%' . $busqueda . '%');
        })
            ->skip($offset)->take($maxRows)->get();


        return response()->json(["result" => $eventos]);
        /*Queda hacer un filtro por tipo */

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
            'nombre' => 'required',
            'descripcion' => 'required',
            'es_pago' => 'required|boolean',
            'precio' => 'required_if:es_pago,true',
            'organizador' => 'required',
            'tipo' => 'required|in:curso,seminarioV,seminarioP',
            // 'nombre_foro' => 'required_if:tipo,curso',
            'nombre_ubicacion' => 'required_if:tipo,seminarioP',
            'latitud' => 'required_if:tipo,seminarioP',
            'longitud' => 'required_if:tipo,seminarioP',
            'maximo_participantes' => 'required_if:tipo,seminarioP',
            // 'nombre_plataforma' => 'required_if:tipo,seminarioV',
            'estado' => 'string',
            'fecha' => 'required|string',
            'hora' => 'required|string',
            'link' => 'required_if:tipo,seminarioV',
            /*
            'modulos' => 'required|array',
            'modulos.*.nombre' => 'required',
            'modulos.*.estado' => 'required',
            'modulos.*.clases' => 'required|array',
            'modulos.*.clases.*.nombre' => 'required',
            'modulos.*.clases.*.duracion' => 'required',
            'modulos.*.clases.*.estado' => 'required',
            'modulos.*.evaluacion.nombre' => 'required',
            'modulos.*.evaluacion.maximo_puntuacion' => 'required',
            'modulos.*.evaluacion.preguntas' => 'required|array',
            'modulos.*.evaluacion.preguntas.*.texto' => 'required',
            'modulos.*.evaluacion.preguntas.*.opciones' => 'required|array',
            'modulos.*.evaluacion.preguntas.*.opciones.*.texto' => 'required',
            'modulos.*.evaluacion.preguntas.*.opciones.*.correcta' => 'required|boolean',
            */
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $evento = new Evento();
        $evento->nombre = $request->input('nombre');
        $evento->descripcion = $request->input('descripcion');
        $evento->es_pago = $request->input('es_pago');
        $evento->precio = $request->input('precio');
        $evento->organizador_id = $request->input('organizador');
        $evento->tipo = $request->input('tipo');
        $evento->save();

        if ($request->tipo === 'curso') {
            $curso = new Curso();
            $curso->evento_id_of_curso = $evento->id;
            $curso->save();

            $foro = new Foro();
            $foro->nombre = $request->nombre;
            $foro->id_curso = $curso->id;
            $foro->save();

        } else if ($request->tipo === 'seminarioV') {
            $seminarioV = new SeminarioVirtual();
            $seminarioV->evento_id = $evento->id;
            $seminarioV->nombre_plataforma = $request->nombre;
            $seminarioV->hora = $request->hora;
            $seminarioV->fecha = $request->fecha;
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
            $seminarioP->longitud = $request->longitud;
            $seminarioP->maximo_participantes = $request->maximo_participantes;
            $seminarioP->save();
        }

        return response()->json([
            'message' => 'El curso se ha creado correctamente.',
            'curso' => $evento,
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