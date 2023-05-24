<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Validator;

function getMyUrl()
{
  $protocol = (!empty($_SERVER['HTTPS']) && (strtolower($_SERVER['HTTPS']) == 'on' || $_SERVER['HTTPS'] == '1')) ? 'https://' : 'http://';
  $server = $_SERVER['SERVER_NAME'];
  $port = $_SERVER['SERVER_PORT'] ? ':'.$_SERVER['SERVER_PORT'] : '';
  return $protocol.$server.$port;
}

class VideoController extends Controller
{
    public function uploadVideo(Request $request)
    {
       try {
        $validator = Validator::make($request->all(), [
            'video' => '',
            'id_clase' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $video = $request->file('video');

        // Guarda el video en la carpeta storage/app/public/videos/{moduloid}/{claseid} con un nombre único
        $storedVideo =  $video->store('videos/'. $request->id_clase, 'public');
        $clase = Clase::find($request->id_clase);
        $exitCode = Artisan::call('storage:link');
        $videoName = $video->hashName();
        $videoPath = trim(getMyUrl() . "/storage/videos/$clase->id/$videoName");

        if(!isset($clase)){
            return response()->json(['ok' => false, 'message' => 'No existe una clase con el id: ' . $request->id_clase], 403);
        }else{
            Clase::where("id", $request->id_clase)->update(['video' => $videoPath]);
        }

        // Retornamos el path del video guardado
        return response()->json(['message' => 'Video uploaded successfully', 'video_path' => $videoPath], 201);
       } catch (\Throwable $th) {
        return response()->json(["ok" => false,'message' => $th->getMessage(), ], 500);
       }
    }

    public function saveVideo($video) : string
    {
        // if ($video->isValid()) {
            // echo var_dump($video);
            $videoPath = $video->store('videos', 'public');
            return $videoPath;
        // } else {
            // Si el video no es válido
            // return null;
        // }
    }
}