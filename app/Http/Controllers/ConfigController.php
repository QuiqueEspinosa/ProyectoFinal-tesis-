<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Config;
use App\Models\Mesa;
use App\Models\Invitado;

class ConfigController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'fecha_evento' => 'nullable|date',
            'clase_evento' => 'nullable|in:casamiento,fiesta_15,fiesta_18',
            'horario' => 'nullable|string',
            'salon' => 'nullable|string',
            'cant_mesas' => 'required|integer',
            'cant_sillas' => 'nullable|integer',
            'cant_total_de_invitados' => 'nullable|integer',
            'precio_adulto' => 'nullable|numeric',
            'precio_menor' => 'nullable|numeric',
            'cant_mesa_principal' => 'nullable|integer',
        ]);

        $config = Config::first() ?? new Config();
        $config->fill($request->all());
        $config->save();

        // Número de mesas a crear
        $nuevasMesas = $request->input('cant_mesas');

        // Crear o actualizar mesa principal
        // $mesaPrincipal = Mesa::updateOrCreate(
        //     ['numero_mesa' => 0],
        //     [
        //         'titulo' => 'Mesa Principal',
        //         'tipo_mesa' => 'Principal',
        //         'posicion' => 0, // Colocamos una posición especial para la mesa principal
        //         'x' => $request->input('x_mesa_principal', 0),
        //         'y' => $request->input('y_mesa_principal', 0),
        //     ]
        // );

        // Eliminar mesas sobrantes si el número de mesas es menor
        $currentMesas = Mesa::where('tipo_mesa', 'Común')->orderBy('numero_mesa')->get();
        foreach ($currentMesas->slice($nuevasMesas) as $mesa) {
            $mesa->delete();
        }

        // Crear o actualizar mesas comunes
        for ($i = 1; $i <= $nuevasMesas; $i++) {
            Mesa::updateOrCreate(
                ['numero_mesa' => $i],
                [
                    'titulo' => 'Mesa ' . $i,
                    'tipo_mesa' => 'Común',
                    'posicion' => $i,
                ]
            );
        }

        // mesa prinsipal 
        $this->crearInvitadosAutomaticos($request->input('clase_evento'));

        return redirect()->back()->with('success', 'Configuración y mesas guardadas exitosamente');
    }
    private function asignarFotoPerfilEvento($claseEvento, $rol)
    {
        switch ($claseEvento) {
            case 'casamiento':
                return $rol === 'novio' ? 'Novio.png' : 'Novia.png';
            case 'fiesta_15':
                return 'Quinsiañera.png';
            case 'fiesta_18':
                return 'Novio.png';
            default:
                return 'usuariootro.png';
        }
    }

    private function crearInvitadosAutomaticos($claseEvento)
    {
        // Eliminar invitados automáticos de eventos previos
        $this->eliminarInvitadosAutomáticos();

        if ($claseEvento === 'casamiento') {
            // Crear novio
            Invitado::updateOrCreate([
                'nombre' => 'Novio',
                'mesa_id' => 1, // Mesa principal
            ], [
                'apellido' => '',
                'edad' => 'adulto',
                'sexo' => 'M',
                'menu' => 'Adulto',
                'especial' => 'si',
                'foto' => $this->asignarFotoPerfilEvento($claseEvento, 'novio'),
                'codigo' => uniqid(),
                'confirmacion' => 'aceptado'
            ]);

            // Crear novia
            Invitado::updateOrCreate([
                'nombre' => 'Novia',
                'mesa_id' => 1, // Mesa principal
            ], [
                'apellido' => '',
                'edad' => 'adulto',
                'sexo' => 'F',
                'menu' => 'Adulto',
                'especial' => 'si',
                'foto' => $this->asignarFotoPerfilEvento($claseEvento, 'novia'),
                'codigo' => uniqid(),
                'confirmacion' => 'aceptado'
            ]);

        } elseif ($claseEvento === 'fiesta_15') {
            // Crear quinceañera
            Invitado::updateOrCreate([
                'nombre' => 'Quinceañera',
                'mesa_id' => 1, // Mesa principal
            ], [
                'apellido' => '',
                'edad' => 'niño',
                'sexo' => 'F',
                'menu' => 'Adulto',
                'especial' => 'si',
                'foto' => $this->asignarFotoPerfilEvento($claseEvento, 'quinceanera'),
                'codigo' => uniqid(),
                'confirmacion' => 'aceptado'
            ]);

        } elseif ($claseEvento === 'fiesta_18') {
            // Crear cumpleañero
            Invitado::updateOrCreate([
                'nombre' => 'Cumpleañero',
                'mesa_id' => 1, // Mesa principal
            ], [
                'apellido' => '',
                'edad' => 'adulto',
                'sexo' => 'M',
                'menu' => 'Adulto',
                'especial' => 'si',
                'foto' => $this->asignarFotoPerfilEvento($claseEvento, 'cumpleanero'),
                'codigo' => uniqid(),
                'confirmacion' => 'aceptado'
            ]);
        }
    }

    private function eliminarInvitadosAutomáticos()
    {
        // Elimina los invitados automáticos que están en la mesa principal
        Invitado::whereIn('nombre', ['Novio', 'Novia', 'Quinceañera', 'Cumpleañero'])
            ->where('mesa_id', 1) // Asegura que solo se eliminen de la mesa principal
            ->delete();
    }


    public function updatePositions(Request $request)
    {
        $positions = $request->input('positions');

        foreach ($positions as $pos) {
            $mesa = Mesa::find($pos['id']);
            if ($mesa) {
                $mesa->x = $pos['x'];
                $mesa->y = $pos['y'];
                $mesa->save();
            }
        }

        return response()->json(['message' => 'Posiciones actualizadas correctamente'], 200);
    }

}
