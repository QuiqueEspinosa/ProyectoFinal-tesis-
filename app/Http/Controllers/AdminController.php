<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Config;
use App\Models\Mesa;
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $config = Config::first(); // Obtener la configuración

        $fechaHoraEvento = null;
        if ($config && $config->fecha_evento && $config->horario) {
            $fechaHoraEvento = $config->fecha_evento . ' ' . $config->horario;
        }

        $mesas = Mesa::orderBy('posicion')->get();

        return view('admin.index', compact('config', 'mesas', 'fechaHoraEvento'));
    }
    
     }