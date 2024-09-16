<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitado extends Model
{
    use HasFactory;

    protected $table = 'invitados';

    protected $fillable = [
        'nombre',
        'apellido',
        'edad',
        'sexo',
        'menu',
        'cant_acompanantes', // Sin tilde
        'confirmacion',
        'codigo',
        'mesa_id', // Relación con la tabla de mesas
        'foto', // Campo para la foto
        'especial',

    ];

    // Mutator para establecer un valor predeterminado para el campo código si no se proporciona
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($invitado) {
            if (empty($invitado->codigo)) {
                $invitado->codigo = strtoupper(bin2hex(random_bytes(3))); // Genera un código único de 6 caracteres
            }
        });
    }

    // Relación con la tabla 'mesas' si es necesario
    public function mesa()
    {
        return $this->belongsTo(Mesa::class);
    }
}
