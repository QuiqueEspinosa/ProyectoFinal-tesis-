<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Config;
use App\Models\Mesa;

class ConfigController extends Controller
{
    public function index()
    {
        $config = Config::first();
        $mesas = Mesa::orderBy('posicion')->get();
        return view('admin.config', compact('config', 'mesas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha_evento' => 'nullable|date',
            'clase_evento' => 'nullable|string',
            'horario' => 'nullable|string',
            'salon' => 'nullable|string',
            'cant_mesas' => 'required|integer',
            'cant_sillas' => 'nullable|integer',
            'cant_total_de_invitados' => 'nullable|integer',
            'precio_adulto' => 'nullable|numeric',
            'precio_menor' => 'nullable|numeric',
            'cant_mesa_principal' => 'nullable|integer',
        ]);

        // Guardar configuración
        $config = Config::first() ?? new Config();
        $config->fill($request->all());
        $config->save();

        $nuevasMesas = $request->input('cant_mesas');
        $currentMesas = Mesa::orderBy('numero_mesa')->get();

        // Calcula cuántas mesas se deben agregar o eliminar
        $leftMesasCount = intval($nuevasMesas / 2);
        $rightMesasCount = $nuevasMesas - $leftMesasCount;

        // Eliminar mesas que no están en la nueva cantidad
        $toDelete = $currentMesas->filter(function ($mesa) use ($nuevasMesas) {
            return $mesa->numero_mesa > $nuevasMesas;
        });

        foreach ($toDelete as $mesa) {
            $mesa->delete();
        }

        // Actualizar mesas existentes o agregar nuevas
        for ($i = 1; $i <= $nuevasMesas; $i++) {
            $lista = ($i <= $leftMesasCount) ? 'izquierda' : 'derecha';
            $mesa = Mesa::updateOrCreate(
                ['numero_mesa' => $i],
                [
                    'titulo' => 'Mesa ' . $i,
                    'nota' => '',
                    'tipo_mesa' => 'General',
                    'posicion' => $i,
                    'lista' => $lista,
                ]
            );
        }

        return redirect()->back()->with('success', 'Configuración y mesas guardadas exitosamente');
    }


    public function updatePositions(Request $request)
    {
        $positions = $request->input('positions');

        foreach ($positions as $pos) {
            $mesa = Mesa::find($pos['id']);
            if ($mesa) {
                $mesa->posicion = $pos['posicion'];
                $mesa->lista = $pos['lista'];
                $mesa->save();
            }
        }

        return response()->json(['message' => 'Posiciones actualizadas correctamente'], 200);
    }
  
    
}
