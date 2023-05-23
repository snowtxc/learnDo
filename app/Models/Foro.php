<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Foro extends Model
{
    

    public function curso(): BelongsTo
    {
        return $this->belongsTo(Curso::class);
    }

    public function publicaciones()
    {
       return $this->hasMany(Comentario::class);

    }
    
}
