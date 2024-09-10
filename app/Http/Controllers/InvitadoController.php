<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invitado;

class InvitadoController extends Controller
{
    // Crear un nuevo invitado
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string',
            'apellido' => 'required|string',
            'edad' => 'required|string',
            'sexo' => 'required|string',
            'mesa_id' => 'nullable|exists:mesas,id', // Asegura que la mesa exista
            'menu' => 'required|string',
            'cant_acompanantes' => 'nullable|integer',

        ]);

        // Asignar la imagen de perfil según el sexo
        $foto = $this->asignarFotoPerfil($validated['sexo']); // Cambié a 'foto' para que sea consistente

        // Crear invitado
        $invitado = Invitado::create([
            'nombre' => $validated['nombre'],
            'apellido' => $validated['apellido'],
            'edad' => $validated['edad'],
            'sexo' => $validated['sexo'],
            'mesa_id' => $validated['mesa_id'], // Ahora usa 'mesa_id' y no 'mesa'
            'menu' => $validated['menu'],
            'cant_acompanantes' => $validated['cant_acompanantes'],
            'codigo' => strtoupper(bin2hex(random_bytes(3))), // Código único
            'confirmacion' => 'en espera', // Valor predeterminado
            'foto' => $foto, // Guardar la foto de perfil
        ]);

        $invitado = Invitado::with('mesa')->find($invitado->id);
        return response()->json($invitado);
      
    }

    private function asignarFotoPerfil($sexo)
    {
        switch ($sexo) {
            case 'M':
                return 'usuariohombre.png'; // Imagen de perfil para hombres
            case 'F':
                return 'usuarioMujer.png';  // Imagen de perfil para mujeres
            default:
                return 'UsuarioOtro.png'; // Imagen de perfil para otro/usuario genérico
        }
    }

    // Editar un invitado
    public function edit($id)
    {
        $invitado = Invitado::findOrFail($id);
        return view('admin.invitados.edit', compact('invitado'));
    }

    // Actualizar un invitado
    public function update(Request $request, $id)
    {
        $invitado = Invitado::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'edad' => 'required|string',  // Edad como string
            'sexo' => 'required|in:M,F,Otro',
            'menu' => 'required|in:Adulto,Infantil,Vegetariano,Dietetico',
            'cant_acompanantes' => 'nullable|integer',
            'confirmacion' => 'required|in:en espera,aceptado,rechazado',
        ]);

        $invitado->update($request->all());

        return response()->json(['success' => 'Invitado actualizado exitosamente']);
    }

    // Eliminar un invitado
    public function destroy($id)
    {
        $invitado = Invitado::findOrFail($id);
        $invitado->delete();

        return response()->json(['success' => 'Invitado eliminado exitosamente']);
    }
}
