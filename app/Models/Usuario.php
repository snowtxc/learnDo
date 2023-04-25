<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Parental\HasChildren;

class Usuario extends \Illuminate\Foundation\Auth\User implements JWTSubject
{
    use HasFactory;
    use HasChildren;

    protected $fillable = ['type'];

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
