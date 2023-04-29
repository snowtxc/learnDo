<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
// use Illuminate\Database\Eloquent\Model;

class Organizador extends Usuario
{
    use HasFactory;
    public function eventos()
    {
        return $this->hasMany(Evento::class);
    }
}
