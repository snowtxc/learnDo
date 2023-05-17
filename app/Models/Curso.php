<?php

namespace App\Models;

use App\Models\Evento;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Curso extends Evento
{
    use HasFactory;

    public function foro(): HasOne
    {
        return $this->hasOne(Foro::class);
    }

}
