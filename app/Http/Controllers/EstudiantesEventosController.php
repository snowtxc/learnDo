<?php

namespace App\Http\Controllers;

use App\Models\estudiantes_eventos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EstudiantesEventosController extends Controller
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
     * @param  \App\Models\estudiantes_eventos  $estudiantes_eventos
     * @return \Illuminate\Http\Response
     */
    public function show(estudiantes_eventos $estudiantes_eventos)
    {
        //
    }

    public function showNuevosAlumnos()
    {
        $meInfo = auth()->user();
        $myId = $meInfo->id;
        $thisMonth = date('Y-m-01');
        $fechaActual = date('Y-m-01', strtotime('+1 months', strtotime($thisMonth)));
        $fechaMonthAgo = date('Y-m-01', strtotime('-1 months', strtotime($thisMonth)));
        $contador = 0;

        while ($contador < 7) {
            $comprasMonthAgo = DB::table('compraevento')
                ->join('eventos', 'eventos.id', '=', 'compraevento.evento_id')
                ->where('eventos.organizador_id', $myId)
                ->where('compraevento.created_at', '>=', $thisMonth)
                ->where('compraevento.created_at', '<', $fechaActual)
                ->whereNotIn('compraevento.estudiante_id', function ($query) use ($myId, $thisMonth) {
                    $query->select('compraevento.estudiante_id')
                        ->from('compraevento')
                        ->join('eventos', 'eventos.id', '=', 'compraevento.evento_id')
                        ->where('eventos.organizador_id', $myId)
                        ->where('compraevento.created_at', '<', $thisMonth);
                })
                ->selectRaw('COUNT(DISTINCT compraevento.estudiante_id) as student_count')
                ->first();

            $gananciasPorMes = DB::table('compraevento')
            ->join('eventos', 'eventos.id', '=', 'compraevento.evento_id')
            ->where('eventos.organizador_id', $myId)
            ->where('compraevento.created_at', '>=', $thisMonth)
            ->where('compraevento.created_at', '<', $fechaActual)
            ->select(DB::raw('SUM(compraevento.monto) as ganancia'))
            ->first();

            $cantVentas = DB::table('compraevento')
                ->join('eventos', 'eventos.id', '=', 'compraevento.evento_id')
                ->where('eventos.organizador_id', $myId)
                ->where('compraevento.created_at', '>=', $thisMonth)
                ->where('compraevento.created_at', '<', $fechaActual)
                ->selectRaw('COUNT(compraevento.id) as ventasTotal')
                ->first();


            $meses[$contador] = $comprasMonthAgo->student_count ?? 0;
            $ganancias[$contador] = $gananciasPorMes->ganancia ?? 0;
            $ventas[$contador] = $cantVentas->ventasTotal ?? 0 ;

            $contador++;
            $thisMonth = date('Y-m-01', strtotime('-1 months', strtotime($thisMonth)));
            $fechaActual = date('Y-m-01', strtotime('-1 months', strtotime($fechaActual)));
        }

        $cantEstudiantes = DB::table('compraevento')
            ->join('eventos', 'eventos.id', '=', 'compraevento.evento_id')
            ->where('eventos.organizador_id', $myId)
            ->selectRaw('COUNT(DISTINCT compraevento.estudiante_id) as estudiantesTotal')
            ->first();
        
        $total["NuevosAlumnos"] = $meses;
        $total["Ganancias"] = $ganancias; 
        $total["CantidadVentas"] = $ventas;
        $total["AlumnosTotales"] = $cantEstudiantes->estudiantesTotal ?? 0;
        return $total;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\estudiantes_eventos  $estudiantes_eventos
     * @return \Illuminate\Http\Response
     */
    public function edit(estudiantes_eventos $estudiantes_eventos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\estudiantes_eventos  $estudiantes_eventos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, estudiantes_eventos $estudiantes_eventos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\estudiantes_eventos  $estudiantes_eventos
     * @return \Illuminate\Http\Response
     */
    public function destroy(estudiantes_eventos $estudiantes_eventos)
    {
        //
    }
}
