<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompraEvento extends Model
{
    use HasFactory;
    protected $table = 'compraevento';

    public function foro(): HasOne
    {
        return $this->hasOne(Foro::class);
    }

}

