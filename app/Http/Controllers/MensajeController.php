<?php

namespace App\Http\Controllers;

use App\Models\Mensaje;
use Illuminate\Http\Request;
use App\Http\Utils\UserUtils;
use Carbon\Carbon;
use Validator;

class MensajeController extends Controller
{

    public function changeMessageIsRead(Request $req){
        try {
            $validator = Validator::make($req->all(), [
                "message_id" => "required|integer",
                "value" => "required|boolean",
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors());
            }
            $msgId = $req->message_id;
            $value = $req->value;
            Mensaje::where("id", $msgId)->update(['isRead' => $value == true ? "1" : "0"]);
            return response()->json([
                "ok" => true,
                "message" => "Mensaje actualizado correctamente"
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "ok" => false,
                "message" => "Error al actualizar el mensaje"
            ]);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMensajes(Request $req)
    {
        $validator = Validator::make($req->all(), [
            "user_id" => "required|integer",
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $uid = $req->user_id;

        $mensajes = Mensaje::where(function ($query) use ($uid) {
            $query->where('user_from_id', '=', $uid)
                ->orWhere('user_to_id', '=', $uid);
        })->get();

        $chats = array();
        $userUtils = new UserUtils();
        $userIds = array();
        if ($mensajes != null) {
            foreach ($mensajes as $mensaje) {
                if (!in_array($mensaje->user_from_id, $userIds) && $mensaje->user_from_id != $uid) {
                    array_push($userIds, $mensaje->user_from_id);
                }
                if (!in_array($mensaje->user_to_id, $userIds) && $mensaje->user_to_id != $uid) {
                    array_push($userIds, $mensaje->user_to_id);
                }
            }
            foreach ($userIds as $userId) {
                $userInfo = $userUtils->userExists($userId);
                $messagesWithUser = array();

                foreach ($mensajes as $msg) {
                    if ($msg->user_from_id == $userId || $msg->user_to_id == $userId) {
                        array_push($messagesWithUser, $msg);
                    }
                }
                $lastMessage = null;
                $isMyLastMessage = false;
                if (count($messagesWithUser) > 0) {
                    $lastMessage = end($messagesWithUser);
                    $isMyLastMessage = end($messagesWithUser)['user_from_id'] == $uid;
                }
                $formattedChat = array(
                    "userId" => $userInfo["id"],
                    "userName" => $userInfo["nombre"],
                    "lastMessage" => $lastMessage,
                    "chatId" =>  $userInfo["id"],
                    "userImage" => $userInfo["imagen"],
                    "isMyLastMessage" => $isMyLastMessage,
                    "messages" => $messagesWithUser,
                );
                array_push($chats, $formattedChat);
            }
        }
        return response()->json($chats);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $req)
    {
        $validator = Validator::make($req->all(), [
            "user_from_id" => "required|integer",
            "user_to_id" => "required|integer",
            "message" => "required|string"
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $userUtils = new UserUtils();
        $userFrom = $userUtils->userExists($req->user_from_id);
        $userTo = $userUtils->userExists($req->user_to_id);

        if ($userFrom == null || $userTo == null) {
            return response()->json([
                "ok" => false,
                "message" => "Datos invalidos"
            ]);
        }
        ;

        $mensaje = new Mensaje();
        $mensaje->user_from_id = $req->user_from_id;
        $mensaje->user_to_id = $req->user_to_id;
        $mensaje->contenido = $req->message;
        $mensaje->fecha_emision = Carbon::now();
        $mensaje->save();

        $newEvent = new ChatEventController($req->user_from_id, $req->user_to_id, $mensaje);
        $newEvent->broadcastOn();
        event($newEvent);

        return response()->json([
            "ok" => true,
            "message" => $mensaje,
        ]);
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
     * @param  \App\Models\Mensaje  $mensaje
     * @return \Illuminate\Http\Response
     */
    public function show(Mensaje $mensaje)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mensaje  $mensaje
     * @return \Illuminate\Http\Response
     */
    public function edit(Mensaje $mensaje)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mensaje  $mensaje
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mensaje $mensaje)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mensaje  $mensaje
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mensaje $mensaje)
    {
        //
    }
}