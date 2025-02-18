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
        $eventos = M_Eventos::with('local')->get();
        $asientos = M_Asientos::all();
        $planes = M_Plan::with('evento')->get();
        $noAsientos = $asientos->isEmpty();
        $locales = M_Locales::all(); // O cualquier lógica que necesites para obtener los locales

        return view('layouts.asientos.V_todosasientos', compact('planes', 'locales', 'eventos', 'asientos', 'noAsientos'));
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

    public function edit($id, Request $request): View
    {
        $asiento = M_Asientos::findOrFail($id);
        $locales = M_Locales::all(); // O cualquier lógica que necesites para obtener los locales
        $eventos = M_Eventos::all(); // Asegúrate de obtener los eventos

        // Si se ha enviado el formulario y se ha cambiado el evento, usa el nuevo evento_id
        $evento_id = $request->get('evento_id', $asiento->evento_id); // Si no se pasa, usa el evento_id del asiento
        $planes = M_Plan::where('evento_id', $evento_id)->get(); // Filtras los planes por el evento_id
        
        //$evento_id = $asiento->evento_id; // Aquí obtienes el evento_id del asiento
        //$planes = M_Plan::where('evento_id', $evento_id)->get(); // Filtras los planes por evento_id
        //$planes = M_Plan::all(); // Asegúrate de obtener los planes

        return view('layouts.asientos.V_editarasiento', compact('asiento', 'locales', 'eventos', 'planes'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'evento_id' => 'required|integer|exists:eventos,id',
                'plan_id' => 'required|integer|exists:plans,id',
                'tipo' => 'required|string|max:255',
                'numero_asiento' => 'required|string|max:255',
                'estado' => 'required|string|max:255',
            ]);

            //dd($request->all());

            // Obtener el tipo del plan seleccionado
            $plan = M_Plan::findOrFail($request->plan_id);

            $validated['tipo'] = $plan->tipo; // Asegurarse de que el tipo de plan se refleje en el tipo del asiento

            $asiento = M_Asientos::findOrFail($id);
            $asiento->update($validated);

            return redirect()->route('asientos.index')->with('success', 'Asiento actualizado exitosamente.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            dd($e->getTraceAsString());
            dd($validated);
            return redirect()->back()->withErrors(['error' => 'Hubo un problema al actualizar el asiento.']);
        }
    }

    // En tu controlador C_Asientos.php
    public function getPlanesByEvento($eventoId)
    {
        $planes = M_Plan::where('evento_id', $eventoId)->get(); // Obtener planes por evento_id

        // Devolver los planes en formato JSON
        return response()->json($planes);
    }

    public function destroy($id): RedirectResponse
    {
        try {
            $asiento = M_Asientos::findOrFail($id);
            $asiento->delete();

            return redirect()->route('asientos.index')->with('success', 'Asiento eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Hubo un problema al eliminar el asiento.']);
        }
    }

    public function ocultar($id): RedirectResponse
    {
        try {
            // Buscar el evento por su ID
            $evento = M_Asientos::findOrFail($id);
        
            // Cambiar el valor de 'visible' a 0 para ocultar el evento
            $evento->visible = 0;
            $evento->save(); // Guardar los cambios
        
            // Redirigir con mensaje de éxito
            return redirect()->route('asientos.index')->with('success', 'Asiento ocultado exitosamente.');
        } catch (\Exception $e) {
            // Si hay un error, lo registramos y mostramos un mensaje de error
            Log::error('Error al ocultar el asiento: ' . $e->getMessage());
            return redirect()->route('asientos.index')->with('error', 'Error al ocultar el asiento.');
        }
    }
}
