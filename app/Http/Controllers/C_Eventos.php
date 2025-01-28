<?php

namespace App\Http\Controllers;

use App\Models\M_Eventos;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

use App\Models\User;
use App\Models\M_Locales;

class C_Eventos extends Controller
{
    public function index(): View
    {
        $eventos = M_Eventos::all();
        $noEventos = $eventos->isEmpty();

        return view('layouts.eventos.V_todoseventos', compact('eventos', 'noEventos'));
    }

    public function create(): View
    {
        $users = User::all();
        $locales = M_Locales::all();

        return view('layouts.eventos.V_agregarevento', compact('users', 'locales'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer',
            'local_id' => 'required|integer',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
            'fecha_evento' => 'required|date',
            'aforo_evento' => 'required|integer',
            'estado' => 'required|in:ACTIVO,CANCELADO,FINALIZADO',
            'Foto' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
        ]);

        if ($request->hasFile('Foto')) {
            $path = $request->file('Foto')->store('eventos', 'public');
        } else {
            $path = null;
        }

        M_Eventos::create([
            'user_id' => $request->user_id,
            'local_id' => $request->local_id,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'fecha_evento' => $request->fecha_evento,
            'aforo_evento' => $request->aforo_evento,
            'estado' => $request->estado,
            'Foto' => $path,
        ]);

        return redirect()->route('eventos.index');
    }
}
