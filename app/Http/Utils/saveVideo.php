<?php
namespace App\Http\Utils;


class saveVideo {

    public function saveVideo($video)
    {
        if ($video->isValid()) {
            $videoPath = $video->store('videos', 'public');
            return $videoPath;
        } else {
            // Si el video no es válido
            return null;
        }
    }
}

?>