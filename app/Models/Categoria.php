<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Categoria extends Model
{
    use HasFactory;

    use SoftDeletes;

    public function eventos()
    {
        return $this->belongsToMany(Categoria::class, 'categoriaeventos', 'categoria_id', 'eventos_id');
    }
}
