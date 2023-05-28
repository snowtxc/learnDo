<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;




class Certificado extends Model
{
    use HasFactory;

    public function curso(){
        return $this->belongsTo(Curso::class,"curso_id","evento_id_of_curso");
    }

    public function estudiante(){
        return $this->belongsTo(Estudiante::class,'user_id', "estudiante_id");  
    }
   
}
