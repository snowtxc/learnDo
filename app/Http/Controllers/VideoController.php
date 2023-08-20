<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

// use Illuminate\Support\Facades\Storage;


// function Download($path, $speed = null)
// {
//     if (is_file($path) === true)
//     {
//         set_time_limit(0);

//         while (ob_get_level() > 0)
//         {
//             ob_end_clean();
//         }

//         $size = sprintf('%u', filesize($path));
//         $speed = (is_int($speed) === true) ? $size : intval($speed) * 1024;

//         header('Expires: 0');
//         header('Pragma: public');
//         header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
//         header('Content-Type: application/octet-stream');
//         header('Content-Length: ' . $size);
//         header('Content-Disposition: attachment; filename="' . basename($path) . '"');
//         header('Content-Transfer-Encoding: binary');

//         for ($i = 0; $i <= $size; $i = $i + $speed)
//         {
//             ph()->HTTP->Flush(file_get_contents($path, false, null, $i, $speed));
//             ph()->HTTP->Sleep(1);
//         }

//         exit();
//     }

//     return false;
// }

function getMyUrl()
{
    $protocol = (!empty($_SERVER['HTTPS']) && (strtolower($_SERVER['HTTPS']) == 'on' || $_SERVER['HTTPS'] == '1')) ? 'https://' : 'http://';
    $server = $_SERVER['SERVER_NAME'];
    $port = $_SERVER['SERVER_PORT'] ? ':' . $_SERVER['SERVER_PORT'] : '';
    return $protocol . $server . $port;
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
            $storedVideo = $video->store('videos/' . $request->id_clase, 'public');
            $clase = Clase::find($request->id_clase);
            $exitCode = Artisan::call('storage:link');
            $videoName = $video->hashName();
            $videoPath = trim(getMyUrl() . "/storage/videos/$clase->id/$videoName");

            if (!isset($clase)) {
                return response()->json(['ok' => false, 'message' => 'No existe una clase con el id: ' . $request->id_clase], 403);
            } else {
                Clase::where("id", $request->id_clase)->update(['video' => $videoPath]);
            }

            // Retornamos el path del video guardado
            return response()->json(['message' => 'Video uploaded successfully', 'video_path' => $videoPath], 201);
        } catch (\Throwable $th) {
            return response()->json(["ok" => false, 'message' => $th->getMessage(),], 500);
        }
    }

    public function getBase64OfVideo(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'claseId' => 'required|int',
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }
            $claseInfo = Clase::find($request->claseId);
            if (!isset($claseInfo)) {
                throw new Exception("Clase invalida");
            }
            $path = $claseInfo->video;
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $hostname = $_SERVER['SERVER_NAME'];

            $url = getMyUrl();
            $newUrl = str_replace("$url/storage/", "", $path);

            // /Users/maximilianoolivera/Documents/Projects/LearnDo/Api/learnDo/publicstorage/videos/24/GrFZQPpmHQ35riB6l2GDXyTcMkTxasX8wfojaC67.mp4{
  
            // return Storage::download(public_path() . $newUrl);
            // return Response::download($newUrl);
            // return Redirect::to($newUrl);

            $file = Storage::disk('public')->get($newUrl);
            // $file=Storage::disk('storage/app/public/')->get($newUrl);
            return (new Response($file, 200))
              ->header('Content-Type', 'video/' . $type);

        } catch (\Throwable $th) {
            return response()->json(["ok" => false, 'message' => $th->getMessage(),], 500);
        }
    }

    public function saveVideo($video): string
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