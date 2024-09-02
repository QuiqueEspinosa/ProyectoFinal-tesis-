<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $table = 'config'; // Especifica la tabla correcta si el nombre de la tabla es singular o diferente.
    
    // Lista los atributos que son asignables en masa
    protected $fillable = [
        'fecha_evento',
        'clase_evento',
        'horario',
        'salon',
        'cant_mesas',
        'cant_sillas',
        'cant_total_de_invitados',
        'precio_adulto',
        'precio_menor',
        'cant_mesa_principal',
    ];
}
