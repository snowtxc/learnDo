<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Usuario extends \Illuminate\Foundation\Auth\User implements JWTSubject
{
    use HasFactory;

    public function publicaciones()
    {
        return $this->hasMany(Publicacion::class);
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }    

    public function status()
    {
        return $this->belongsTo(UserStatus::class);
    }

}
