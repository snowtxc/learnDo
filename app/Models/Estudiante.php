<?php

namespace App\Models;


// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Usuario
{
    public function certificados()
    {
        return $this->hasMany(Certificado::class);
    }
    
    public function evaluaciones()
    {
        return $this->hasMany(Evaluacion::class);
    }  
    
    public function compras()
    {
        return $this->belongsToMany(Evento::class, 'compra_evento', 'estudiante_id','evento_id');
    }
}
