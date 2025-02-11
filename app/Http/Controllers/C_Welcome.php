<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

use App\Models\M_Eventos;
use App\Models\M_Plan;

class C_Welcome extends Controller
{
    public function index(): View
    {
        $eventos =  M_Eventos::with('local')->get();
        $noEventos = $eventos->isEmpty();

        return view('welcome', compact('eventos', 'noEventos'));
    }

    public function show($id): View
    {
        $evento = M_Eventos::with(['local', 'planes'])->find($id);

        return view('eventoinfo', compact('evento'));
    }

    public function all(): View
    {
        $eventos = M_Eventos::all();
        $noEventos = $eventos->isEmpty();

        // Eventos Recientes (ordenados por fecha de creación)
        $recientes = M_Eventos::orderBy('created_at', 'desc')->get();

        // Fecha actual
        $hoy = \Carbon\Carbon::now('UTC');

        // Muestra las fechas de inicio y fin del rango
        //dd($hoy, $hoy->copy()->addDays(7));        
        $cercaDeComenzar = M_Eventos::where('fecha_inicio', '<=', $hoy->copy()->addDays(7)) // Cambié el operador a '<='
            ->orderBy('fecha_inicio', 'asc')
            ->get();
        //dd($cercaDeComenzar);

        // Eventos por Artista/Grupo (ordenados alfabéticamente por ArtistaGrupo)
        $porArtista = M_Eventos::orderBy('ArtistaGrupo', 'asc')->get();

        // Verifica si hay eventos en cada categoría
        $noEventosRecientes = $recientes->isEmpty();
        $noEventosCercaDeComenzar = $cercaDeComenzar->isEmpty();
        $noEventosPorArtista = $porArtista->isEmpty();

        // Lógica para filtrar según el parámetro 'orderBy'
        if (request('orderBy') == 'recientes') {
            $eventos = $recientes;
        } elseif (request('orderBy') == 'cerca_de_comenzar') {
            $eventos = $cercaDeComenzar;
        } elseif (request('orderBy') == 'artista_grupo') {
            $eventos = $porArtista;
        }    

        return view('eventos', compact(
            'eventos', 
            'noEventos', 
            'recientes', 
            'cercaDeComenzar', 
            'porArtista',
            'noEventosRecientes',
            'noEventosCercaDeComenzar',
            'noEventosPorArtista'
        ));
    }
}
