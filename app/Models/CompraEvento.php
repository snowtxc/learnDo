<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\BelongsTo;
class CompraEvento extends Model
{
    use HasFactory;
    protected $table = 'compraevento';

    public function foro(): HasOne
    {
        return $this->hasOne(Foro::class);
    }

    public function estudiante()
    {
       return $this->belongsTo(Usuario::class, 'estudiantes', "user_id", "estudiante_id");

    }

    public function evento()
    {
        return $this->belongsTo(Evento::class, 'eventos', "id", "evento_id" );
    }



}

