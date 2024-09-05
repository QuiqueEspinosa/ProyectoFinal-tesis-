<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mesa extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_mesa',
        'titulo',
        'nota',
        'tipo_mesa',
        'posicion',
        'lista',
        'x',
        'y',
    ];
}
