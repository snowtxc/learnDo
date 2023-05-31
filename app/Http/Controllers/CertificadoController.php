<?php

namespace App\Http\Controllers;

use App\Models\Certificado;
use App\Models\Usuario;
use App\Models\Evento;
use App\Models\Curso;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use PDF;
use Validator;
use App\Http\Utils\CursoUtils;



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
       
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $req)
    {
        $validator = Validator::make($req->all(), [
            "curso_id" => "required"
        ]);
    
        try{
            $userInfo = auth()->user();
            $userId  = $userInfo["id"];


            $cursoId = $req->input("curso_id");
            $curso = Curso::where(["evento_id_of_curso" => $cursoId])->first();
            if($curso == null){
                return response()->json(["message" => "El curso no existe"] ,404);
            }

            if(Certificado::where(["estudiante_id"  => $userId, "curso_id" => $cursoId])->first() != null){
                return response()->json(["message" => "Ya tienes un certificado de este curso"] ,400);
            }

            $cursoUtils = new CursoUtils();
            $canGetCertificate =  $cursoUtils->canStudentGetCertificate($userId, $cursoId, $curso->porcentaje_aprobacion);

            if(!$canGetCertificate["isApproved"]){
                return response()->json(["message" => "No puedes obtener el certificado de este curso"] ,400);
            } 

            $newCertificate = new Certificado();
            $newCertificate->nombre = "";
            $newCertificate->estudiante_id = $userId;
            $newCertificate->curso_id  = $cursoId;
            $newCertificate->save();

            return response()->json($newCertificate ,200);

        }catch(Exception $e){
            return response()->json(["message" => "Ha ocurrido un error inesperado"] ,500);
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
