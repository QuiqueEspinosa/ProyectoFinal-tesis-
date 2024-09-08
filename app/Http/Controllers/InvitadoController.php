<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invitado;

class InvitadoController extends Controller
{


    // Crear un nuevo invitado
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'edad' => 'required|string',  // edad será un string para aceptar [bebe, niño, adulto]
            'sexo' => 'required|in:M,F,Otro',
            'menu' => 'required|in:Adulto,Infantil,Vegetariano,Dietetico',
            'cant_acompanantes' => 'nullable|integer',
            'confirmacion' => 'required|in:en espera,aceptado,rechazado',
        ]);

        // Crear el invitado con un código generado automáticamente
        $invitado = Invitado::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'edad' => $request->edad,
            'sexo' => $request->sexo,
            'menu' => $request->menu,
            'cant_acompanantes' => $request->cant_acompanantes,
            'confirmacion' => $request->confirmacion,
            'codigo' => strtoupper(bin2hex(random_bytes(3))) // Genera un código de 6 caracteres
        ]);


        // Retornar los datos del invitado recién creado como JSON
        return response()->json($invitado);
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
            'edad' => 'required|string',  // edad como string
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
