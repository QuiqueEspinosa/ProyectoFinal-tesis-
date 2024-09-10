<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Config;
use App\Models\Mesa;
use App\Models\Invitado;

class AdminController extends Controller
{
    public function index()
    {
        $invitados = Invitado::all();
        $config = Config::first();

         // Contar los invitados por estado
    $enEsperaCount = $invitados->where('confirmacion', 'en espera')->count();
    $rechazadosCount = $invitados->where('confirmacion', 'rechazado')->count();
    $confirmadosCount = $invitados->where('confirmacion', 'aceptado')->count();
      // Contar los invitados sin mesa asignada
      $sinMesaCount = $invitados->whereNull('mesa_id')->count();

        $fechaHoraEvento = $config && $config->fecha_evento && $config->horario
            ? $config->fecha_evento . ' ' . $config->horario
            : null;

        $mesaPrincipal = Mesa::where('tipo_mesa', 'Principal')->first();
        if (!$mesaPrincipal) {
            $mesaPrincipal = Mesa::create([
                'titulo' => 'Mesa Principal',
                'tipo_mesa' => 'Principal',
                'posicion' => 1,
            ]);
        }

        $mesas = Mesa::where('tipo_mesa', 'Común')->orderBy('posicion')->get();

        return view('admin.index', compact('config', 'mesas', 'mesaPrincipal', 'fechaHoraEvento','invitados','enEsperaCount', 'rechazadosCount', 'confirmadosCount', 'sinMesaCount'));
    }


    // app/Http/Controllers/AdminController.php

    public function addTable(Request $request)
    {
        $request->validate([
            'x' => 'nullable|integer',
            'y' => 'nullable|integer',
        ]);
    
        $ultimoNumero = Mesa::where('tipo_mesa', 'Común')->max('numero_mesa') ?? 0;
        $numeroMesa = $ultimoNumero + 1;
    
        $mesa = Mesa::create([
            'numero_mesa' => $numeroMesa,
            'titulo' => 'Mesa ' . $numeroMesa,
            'tipo_mesa' => 'Común',
            'x' => $request->input('x', 0),
            'y' => $request->input('y', 0),
            'posicion' => $numeroMesa,
        ]);
    
        $mesas = Mesa::where('tipo_mesa', 'Común')->orderBy('posicion')->get();
    
        return response()->json(['success' => true, 'mesas' => $mesas], 201);
    }
    
    public function removeLastTable()
    {
        $mesa = Mesa::where('tipo_mesa', 'Común')->orderBy('posicion', 'desc')->first();

        if ($mesa) {
            $mesa->delete();
            return response()->json(['success' => true], 200);
        }

        return response()->json(['success' => false, 'message' => 'No hay mesas para eliminar'], 404);
    }

}
