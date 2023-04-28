<?php

namespace App\Models;
use Parental\HasChildren;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;
    use HasChildren;

    protected $fillable = ['type'];

}
