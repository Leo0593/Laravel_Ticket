<?php

namespace App\Http\Controllers;

use App\Models\M_Eventos;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class C_Welcome extends Controller
{
    public function index(): View
    {
        $eventos =  M_Eventos::with('local')->get();
        $noEventos = $eventos->isEmpty();

        return view('welcome', compact('eventos', 'noEventos'));
    }
}
