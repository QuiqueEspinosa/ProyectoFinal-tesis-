<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invitado;

class ConfirmacionController extends Controller
{
    // Mostrar el formulario para ingresar el código del invitado
    public function index()
    {
        return view('confirmacion.index');
    }

    // Procesar el código del invitado
    public function confirmar(Request $request)
    {
        // Validar el código
        $request->validate([
            'codigo' => 'required|exists:invitados,codigo',
        ]);

        // Buscar al invitado por el código
        $invitado = Invitado::where('codigo', $request->codigo)->first();

        // Determinar si el invitado tiene acompañantes asignados
        $tiene_acompanantes = $invitado->cant_acompanantes > 0;

        // Definir el máximo de acompañantes que puede agregar
        $acompanantes_maximos = $invitado->cant_acompanantes;

        // Mostrar la vista para confirmar la asistencia
        return view('confirmacion.confirmar', [
            'invitado' => $invitado,
            'tiene_acompanantes' => $tiene_acompanantes,
            'acompanantes_maximos' => $acompanantes_maximos, // Agregar esta línea
        ]);
    }

    // Guardar la confirmación del invitado y sus acompañantes
    // Guardar la confirmación del invitado y sus acompañantes
    public function guardar(Request $request)
    {
        $request->validate([
            'invitado_id' => 'required|exists:invitados,id',
            'confirmacion' => 'required|in:aceptado,rechazado',
            'acompanantes' => 'nullable|array|max:' . ($request->input('acompanantes_maximos') ?? 0),
        ]);
    
        // Actualizar la confirmación del invitado
        $invitado = Invitado::find($request->invitado_id);
        $invitado->confirmacion = $request->confirmacion;
        $invitado->save();
    
        // Registrar los acompañantes si el invitado los tiene
        if ($request->has('acompanantes')) {
            foreach ($request->acompanantes as $acompanante) {
                // Generar código para el acompañante
                $codigo_acompanante = 'Acom' . strtoupper(uniqid());
    
                // Asignar la foto según el sexo
                $foto = $this->asignarFoto($acompanante['sexo'] ?? 'otro');
    
                // Crear el acompañante como un nuevo invitado
                Invitado::create([
                    'nombre' => $acompanante['nombre'] ?? 'Sin nombre',
                    'apellido' => $acompanante['apellido'] ?? 'Sin apellido',
                    'edad' => $acompanante['edad'] ?? 'adulto',
                    'sexo' => $acompanante['sexo'] ?? 'otro',
                    'menu' => $acompanante['menu'] ?? 'Adulto',
                    'cant_acompanantes' => 0,  // Los acompañantes no pueden tener otros acompañantes
                    'confirmacion' => 'aceptado',  // Los acompañantes están confirmados automáticamente
                    'especial' => 'no',  // Por defecto, los acompañantes no son especiales
                    'codigo' => $codigo_acompanante,  // Código generado
                    'mesa_id' => null,  // Sin mesa asignada
                    'foto' => $foto,  // Asignar la foto
                ]);
            }
        }
    
        return redirect()->route('confirmacion.index')->with('success', 'Confirmación guardada exitosamente.');
    }
    
    // Método para asignar la foto según el sexo
    private function asignarFoto($sexo)
    {
        switch ($sexo) {
            case 'M':
                return 'usuariohombre.png';
            case 'F':
                return 'usuariomujer.png';
            default:
                return 'usuariootro.png';
        }
    }
    

}
