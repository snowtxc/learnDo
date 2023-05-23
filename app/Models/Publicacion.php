<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publicacion extends Model
{

    protected $fillable = ['nombre','contenido'];

    use HasFactory;

    public function comentarios() {
        return $this->hasMany(Comentario::class);
    }

    public function foro(){
        return $this->belongsTo(Foro::class);

    }
}
