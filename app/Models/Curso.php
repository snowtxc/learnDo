<?php

namespace App\Models;

use App\Models\Evento;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
<<<<<<< HEAD
use Illuminate\Database\Eloquent\Relations\HasMany; 
=======
use Illuminate\Database\Eloquent\Relations\HasMany;
>>>>>>> 921d26b22ee8198da0bed40d3e27f91bbc3a5187

class Curso extends Evento
{
    use HasFactory;

    public function foro(): HasOne
    {
        return $this->hasOne(Foro::class);
    }

<<<<<<< HEAD
    public function comentarios():HasMany {
        return $this->hasMany(Comentario::class);
    }

    public function certificados():HasMany {
        return $this->hasMany(Certificado::class,"curso_id","evento_id_of_curso"); 
=======
    public function modulos(): HasMany 
    { 
        return $this->hasMany(Modulo::class,"curso_id", "evento_id_of_course");
>>>>>>> 921d26b22ee8198da0bed40d3e27f91bbc3a5187
    }

}
