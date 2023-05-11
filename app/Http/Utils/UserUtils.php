<?php
namespace App\Http\Utils;

use App\Models\Usuario;

class UserUtils {

    function userExists($uid) {
        $userInfo = Usuario::find($uid);
        if (!isset($userInfo) || $userInfo == null) {
            return null;
        }
        return $userInfo;
    }
}

?>