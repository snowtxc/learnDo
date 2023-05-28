<?php

namespace App\Models;


// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Estudiante extends Usuario
{
    public function certificados()
    {
        return $this->hasMany(Certificado::class,"estudiante_id","user_id");
    }
    
    public function evaluaciones()
    {
        return $this->hasMany(Evaluacion::class);
    }  
    
    public function compras()
    {
        return $this->hasMany(Compra::class, 'compra_evento', 'estudiante_id','user_id');
    }


}
