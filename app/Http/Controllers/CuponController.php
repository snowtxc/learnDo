<?php

namespace App\Http\Controllers;

use App\Models\Cupon;
use App\Models\Evento;
use App\Models\Usuario;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Validator;
use App\Http\Controllers\CuponJWT;

class CuponController extends Controller
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
    public function usarCupon(Request $request)
    {
        try {
            // $validator = Validator::make($request->all(), [
            //     'evento_id' => 'required',
            //     'user_id_from' => 'required',
            // ]);
            $token = $request->token;
            $loggedUser = auth()->user();
            if (!isset($token) || !isset($loggedUser)) {
                throw new Exception("Token invalido");
            }
            $claims = json_decode(base64_decode(str_replace('_', '/', str_replace('-','+',explode('.', $token)[1]))));
            $cuponId = $claims->cuponId;
            $expires = $claims->expires_in;
            if (!isset($cuponId) || !isset($expires)) {
                throw new Exception("Error validando cupon");
            }
            
            $cuponInfo = Cupon::find($cuponId);
            if (!isset($cuponInfo)) {
                throw new Exception("Invalid token");
            }

            if ($cuponInfo->activo == false) {
                throw new Exception("Cupon invalido");
            } 

            if ($loggedUser->id == $cuponInfo->user_id_from) {
                throw new Exception("No puedes usar tu propio cupon");
            } 

            Cupon::where("id", "=", $cuponId)->update([
                "activo" => false,
            ]);

            $userInfo = Usuario::find($cuponInfo->user_id_from);
            if (!isset($userInfo)) {
                throw new Exception("Error validando datos del cupon");
            }
            
            Usuario::where("id", "=", $cuponInfo->user_id_from)->update([
                "creditos_number" => $userInfo->creditos_number + 10,
            ]);
            
            return response()->json([
                "ok" => true,
                "message" => "Cupon usado correctamente"
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                "ok" => false,
                "message" => $th->getMessage(),
            ]);
        }
    }


    public function validarCupon(Request $request)
    {
        try {
            // $validator = Validator::make($request->all(), [
            //     'evento_id' => 'required',
            //     'user_id_from' => 'required',
            // ]);
            $token = $request->token;
            $eventoId = $request->eventoId;
            if (!isset($token)) {
                throw new Exception("Token invalido");
            }
            $claims = json_decode(base64_decode(str_replace('_', '/', str_replace('-','+',explode('.', $token)[1]))));
            $cuponId = $claims->cuponId;
            $expires = $claims->expires_in;
            if (!isset($cuponId) || !isset($expires)) {
                throw new Exception("Error validando cupon");
            }
            
            $formatExpire = Carbon::parse($expires); 
            if ($formatExpire->isBefore(Carbon::now())) {
                throw new Exception("Expire token");
            }
            $cuponInfo = Cupon::find($cuponId);
            if (!isset($cuponInfo)) {
                throw new Exception("Invalid token");
            }
            if ($cuponInfo->evento_id != $eventoId) {
                throw new Exception("Invalid token");
            }
            $isValid = $cuponInfo->activo;

            if ($isValid == false) {
                Cupon::where("id", "=", $cuponId)->update([
                    "activo" => false,
                ]);
            }
            
            return response()->json([
                "ok" => true,
                "esValido" => $isValid == 1 ? true : false,
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
    public function generateNewCupon(Request $request)
    {
        try {
            // $validator = Validator::make($request->all(), [
            //     'evento_id' => 'required',
            //     'user_id_from' => 'required',
            // ]);
            $eventoInfo = Evento::find($request->evento_id);
            if (!isset($eventoInfo)) {
                throw new Exception("Evento no existe");
            }
            $userInfo = Usuario::find($request->user_id_from);
            if (!isset($userInfo)) {
                throw new Exception("Usuario no existe");
            }

            $vencimiento = Carbon::now()->addDays(5);;
            $cuponInfo = new Cupon();
            $cuponInfo->token = '';
            $cuponInfo->descuento = 10;
            $cuponInfo->fecha_vencimiento = $vencimiento;
            $cuponInfo->user_id_from = $userInfo->id;
            $cuponInfo->evento_id = $eventoInfo->id;
            $cuponInfo->activo = true;
            $cuponInfo->save();
            
            $cuponUtils = new CuponJWT($cuponInfo->id);
            $token = $cuponUtils->createJWT($cuponInfo->id);
            Cupon::where("id", "=", $cuponInfo->id)->update([
                "token" => $token,
            ]);

            
            return response()->json([
                "ok" => true,
                "message" => "Cupon creado correctamente",
                "token" => $token,
                "cuponId" => $cuponInfo->id,
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                "ok" => false,
                "message" => $th->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cupon  $cupon
     * @return \Illuminate\Http\Response
     */
    public function show(Cupon $cupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cupon  $cupon
     * @return \Illuminate\Http\Response
     */
    public function edit(Cupon $cupon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cupon  $cupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cupon $cupon)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cupon  $cupon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cupon $cupon)
    {
        //
    }
}
