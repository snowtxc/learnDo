<?php

namespace App\Http\Controllers;

use App\Models\Certificado;
use App\Models\Usuario;
use App\Models\Evento;


use Illuminate\Http\Request;
use PDF;

class CertificadoController extends Controller
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

    public function __construct() {
        $this->middleware('jwt');
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
     * @param  \App\Models\Certificado  $certificado
     * @return \Illuminate\Http\Response
     */
    public function show(Certificado $certificado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Certificado  $certificado
     * @return \Illuminate\Http\Response
     */
    public function edit(Certificado $certificado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Certificado  $certificado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Certificado $certificado)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Certificado  $certificado
     * @return \Illuminate\Http\Response
     */
    public function destroy(Certificado $certificado)
    {
        //
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getCertificationPdf($id,Request $req){
        
        $certificado = Certificado::find($id);  
        if($certificado == null){
            return response([], 404);
        }

        $usuario = Usuario::find($certificado->estudiante_id);
        $curso = Evento::find($certificado->curso_id);

        $data = array(
            "user_nombre" => $usuario->nombre,
            "curso_nombre" => $curso->nombre,
            "user_avatar" => $usuario->imagen
        );
        $pdf = PDF::loadView('certification',$data);
        return $pdf->download('certification.pdf');

    }
}
