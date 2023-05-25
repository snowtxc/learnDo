<?php

namespace App\Models;

use App\Models\Evento;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Curso extends Evento
{
    use HasFactory;

    public function foro(): HasOne
    {
        return $this->hasOne(Foro::class);
    }

    public function modulos(): HasMany 
    { 
        return $this->hasMany(Modulo::class,"curso_id", "evento_id_of_course");
    }

}
