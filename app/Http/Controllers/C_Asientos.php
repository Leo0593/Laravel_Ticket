<?php

namespace App\Http\Controllers;

use App\Models\M_Asientos;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

use App\Models\M_Locales;
use App\Models\M_Eventos;
use App\Models\M_Plan;

class C_Asientos extends Controller
{
    public function index(): View
    {
        $asientos = M_Asientos::all();
        $noAsientos = $asientos->isEmpty();

        return view('layouts.asientos.V_todosasientos', compact('asientos', 'noAsientos'));
    }

    public function create(): View
    {
        // Obtener todos los locales de la base de datos
        $locales = M_Locales::all(); // O cualquier lógica que necesites para obtener los locales
        $eventos = M_Eventos::all(); // Asegúrate de obtener los eventos
        $planes = M_Plan::all(); // Asegúrate de obtener los planes

        return view('layouts.asientos.V_agregarasiento', compact('locales', 'eventos', 'planes')); // Aquí se pasa 'locales'
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'local_id' => 'required|integer|exists:locales,id',
            'evento_id' => 'required|integer|exists:eventos,id',
            'plan_id' => 'required|integer|exists:plans,id',
            'tipo' => 'required|string|max:255',
            'numero_asiento' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
        ]);

        try {
            M_Asientos::create($validated);

            return redirect()->route('asientos.index')->with('success', 'Asiento creado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Hubo un problema al crear el asiento.']);
        }
    }
}
