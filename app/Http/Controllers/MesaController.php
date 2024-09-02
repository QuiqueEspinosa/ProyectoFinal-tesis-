<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mesa;

class MesaController extends Controller
{
    public function syncMesas($cant_mesas)
    {
        $currentCount = Mesa::count();

        if ($cant_mesas > $currentCount) {
            for ($i = $currentCount + 1; $i <= $cant_mesas; $i++) {
                $lista = ($i <= intval($cant_mesas / 2)) ? 'izquierda' : 'derecha';
                Mesa::create([
                    'numero_mesa' => $i,
                    'posicion' => null,
                    'titulo' => "Mesa $i",
                    'tipo_mesa' => 'General',
                    'nota' => '',
                    'lista' => $lista,
                ]);
            }
        } elseif ($cant_mesas < $currentCount) {
            Mesa::where('numero_mesa', '>', $cant_mesas)->delete();
        }
    }

    public function ordenar(Request $request)
    {
        $order = $request->input('order');

        foreach ($order as $mesaData) {
            Mesa::where('id', $mesaData['id'])->update([
                'posicion' => $mesaData['position'],
                'lista' => $mesaData['lista'] ?? 'izquierda' // Asegúrate de que la lista también se actualice si es necesario
            ]);
        }

        return response()->json(['success' => true]);
    }
}
