<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invitado;
use App\Models\Mesa;
use App\Models\Config;

use Barryvdh\DomPDF\Facade\Pdf;

class InvitadoController extends Controller
{
    // Crear un nuevo invitado
    public function store(Request $request)
    {
        // Validar los datos del request
        $validated = $request->validate([
            'nombre' => 'required|string',
            'apellido' => 'required|string',
            'edad' => 'required|string',
            'sexo' => 'required|string',
            'mesa_id' => 'nullable|exists:mesas,id',
            'menu' => 'required|string',
            'cant_acompanantes' => 'nullable|integer',
            
        ]);

        // Asignar la imagen de perfil según el sexo
        $foto = $this->asignarFotoPerfil($validated['sexo']);

        // Verificar si se ha seleccionado una mesa
        if ($validated['mesa_id']) {
            // Obtener la mesa a la que se asignará el invitado
            $mesa = Mesa::find($validated['mesa_id']);

            // Obtener la cantidad de sillas permitidas por mesa desde la configuración
            $config = Config::first();
            $maxSillas = $config->cant_sillas;

            // Contar los invitados ya asignados a esa mesa, incluyendo acompañantes
            $invitadosEnMesa = Invitado::where('mesa_id', $mesa->id)->sum('cant_acompanantes') + Invitado::where('mesa_id', $mesa->id)->count();

            // Verificar si la mesa ya está llena
            if ($invitadosEnMesa >= $maxSillas) {
                return response()->json(['error' => 'La mesa ' . $mesa->numero_mesa . ' está llena.'], 400);
            }
        }

        // Crear invitado
        $invitado = Invitado::create([
            'nombre' => $validated['nombre'],
            'apellido' => $validated['apellido'],
            'edad' => $validated['edad'],
            'sexo' => $validated['sexo'],
            'mesa_id' => $validated['mesa_id'],
            'menu' => $validated['menu'],
            'cant_acompanantes' => $validated['cant_acompanantes'],
            'codigo' => strtoupper(bin2hex(random_bytes(3))),
            'confirmacion' => 'en espera',
            'especial' => 'no',
            'foto' => $foto,
        ]);

        // Devolver la respuesta con el invitado creado
        return response()->json(Invitado::with('mesa')->find($invitado->id));
    }


    private function asignarFotoPerfil($sexo)
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

    public function edit($id)
    {
        $invitado = Invitado::findOrFail($id);
        $mesas = Mesa::all(); // O el modelo adecuado para obtener las mesas
        return view('admin.edit_invitado', compact('invitado', 'mesas'));
    }

    public function update(Request $request, $id)
    {
        $invitado = Invitado::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'edad' => 'required|string',
            'mesa_id' => 'nullable|exists:mesas,id',
            'sexo' => 'required|in:M,F,Otro',
            'menu' => 'required|in:Adulto,Infantil,Vegetariano,Dietetico',
            'cant_acompanantes' => 'nullable|integer',
            'confirmacion' => 'required|in:en espera,aceptado,rechazado', // Validar la confirmación
       
        ]);

        // Actualizar los datos del invitado, excepto 'mesa_id' ya que lo manejaremos manualmente
        $invitado->update($request->except('mesa_id'));

        // Si el estado de confirmación es 'rechazado', asignar mesa_id como null
        if ($request->confirmacion == 'rechazado') {
            $invitado->mesa_id = null;
        } else {
            // Si no está rechazado, actualizar 'mesa_id' normalmente
            $invitado->mesa_id = $request->mesa_id;
        }

        // Guardar los cambios manualmente después de actualizar mesa_id
        $invitado->save();
        // Devolver una respuesta JSON
        return back()->with('success', 'Invitado actualizado correctamente');
    }


    public function destroy($id)
    {
        $invitado = Invitado::find($id);
        if ($invitado) {
            $invitado->delete();
            return response()->json(['success' => 'Eliminado Correctamente']);
        } else {
            return response()->json(['success' => 'No se Pudo Eliminar'], 404);
        }
    }


    public function listaInvitados()
    {
        $invitados = Invitado::all(); // O aplica filtros según lo que necesites
        return view('admin.listaInvitados', compact('invitados'));
    }

    public function exportPDF(Request $request)
    {
        // Obtener el criterio de ordenamiento de la solicitud
        $sort = $request->query('sort', 'nombre'); // Valor predeterminado 'nombre'
        $direction = $request->query('direction', 'asc'); // Valor predeterminado 'asc'
    
        // Definir el criterio de ordenamiento y la relación
        $sortColumn = $sort;
        if ($sort === 'mesa') {
            $sortColumn = 'numero_mesa';
        }
    
        // Consultar la base de datos con el ordenamiento aplicado
        $invitados = Invitado::where('confirmacion', '<>', 'rechazado')
                            ->join('mesas', 'invitados.mesa_id', '=', 'mesas.id')
                            ->orderBy($sortColumn, $direction)
                            ->select('invitados.*', 'mesas.numero_mesa') // Seleccionar los campos necesarios
                            ->get();
    
        // Generar el PDF
        $pdf = Pdf::loadView('pdf.invitados', ['invitados' => $invitados]);
        return $pdf->download('lista_invitados.pdf');
    }
    

}
