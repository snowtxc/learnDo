<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    use HasFactory;
    public function clases()
    {
        return $this->hasMany(Clase::class);
    }

    public function evaluaciones() {
        return $this->hasMany(Evaluacion::class);
    }
}
