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
        $eventos = M_Eventos::with('local')->get();
        $noEventos = $eventos->isEmpty();

        return view('eventos', compact('eventos', 'noEventos'));
    }
}
