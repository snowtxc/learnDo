<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Evento extends Model
{
    use HasFactory;
    public function organizador()
    {
        return $this->belongsTo(Organizador::class);
    }

    public function categorias()
    {
        return $this->belongsToMany(Categoria::class, 'categoriaeventos', 'evento_id', 'categoria_id');

    }

    public function compras()
    {
        return $this->belongsToMany(Estudiante::class, 'compra_evento', 'evento_id', 'estudiante_id');
    }

}
