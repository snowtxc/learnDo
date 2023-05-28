<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Modulo extends Model
{
    use HasFactory;
    public function clases()
    {
        return $this->belongsTo(Clase::class);
    }

    public function evaluaciones() {
        return $this->hasMany(Evaluacion::class, "evento_id_of_course","curso_id");
    }
}
