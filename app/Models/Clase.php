<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clase extends Model
{
    use HasFactory;

    public function modulos(): HasMany
    {
        return $this->hasMany(Modulo::class);
    }
}
