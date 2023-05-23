<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use Illuminate\Http\Request;
use Validator;

class VideoController extends Controller
{
    public function uploadVideo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'video' => 'required',
            'id_clase' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $video = $request->file('video');

        // Guarda el video en la carpeta storage/app/public/videos/{moduloid}/{claseid} con un nombre único
        $videoPath = '/storage/app/public/' . $video->store('videos/'. $request->id_clase, 'public');
        $clase = Clase::find($request->id_clase);

        if(!isset($clase)){
            return response()->json(['ok' => false, 'message' => 'No existe una clase con el id: ' . $request->id_clase], 403);
        }else{
            Clase::where("id", $request->id_clase)->update(['video' => $videoPath]);
        }

        // Retornamos el path del video guardado
        return response()->json(['message' => 'Video uploaded successfully', 'video_path' => $videoPath], 201);
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