<?php

namespace App\Http\Controllers;

use App\Models\M_Eventos;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

use Illuminate\Support\Facades\Log;

use App\Models\User;
use App\Models\M_Locales;
use App\Models\M_Asientos;

class C_Eventos extends Controller
{
    public function index(): View
    {
        $eventos =  M_Eventos::with('local')->get();
        $noEventos = $eventos->isEmpty();

        return view('layouts.eventos.V_todoseventos', compact('eventos', 'noEventos'));
    }

    public function create(): View
    {
        $users = User::all();
        $locales = M_Locales::all();

        return view('layouts.eventos.V_agregarevento', compact('users', 'locales'));
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required|integer',
                'local_id' => 'required|exists:locales,id', 
                'nombre' => 'required|string|max:255',
                'descripcion' => 'nullable|string',
                'fecha_inicio' => 'required|date|before_or_equal:fecha_fin',
                'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
                'fecha_evento' => 'required|date|after_or_equal:fecha_fin',
                'aforo_evento' => 'required|integer', // Dependiendo del aforo del local, el aforo_evento debe ser menor o igual
                'estado' => 'required|in:ACTIVO,CANCELADO,FINALIZADO',
                'Foto' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg,webp,avif|max:2048',
            ]);

            // Si la foto fue subida, guardarla
            if ($request->hasFile('Foto')) {
                // Guardamos la foto en el directorio 'eventos' dentro de 'public' (con nombre único)
                $path = $request->file('Foto')->store('eventos', 'public');
            } else {
                $path = null; // Si no hay foto, asignamos null
            }
        
            // Añadir la ruta de la foto a los datos validados (si fue subida)
            $validated['Foto'] = $path;

            // Comprobar si el evento ya existe con la misma combinación de datos (como nombre, fecha, etc.)
            $existingEvent = M_Eventos::where('nombre', $validated['nombre'])
            ->where('fecha_inicio', $validated['fecha_inicio'])
            ->where('fecha_fin', $validated['fecha_fin'])
            ->first();

            // Si ya existe un evento con los mismos detalles, no lo creamos nuevamente
            if ($existingEvent) {
                return redirect()->route('eventos.index')->with('error', 'El evento ya existe.');
            }

            // Guardar el evento en la base de datos
            $evento = M_Eventos::create($validated);

            //=============== ASIENTOS ===============\\
            // Crear los asientos asociados con este evento
            for ($i = 1; $i <= $request->aforo_evento; $i++) {
                // Crear un asiento para el evento creado
                M_Asientos::create([
                    'local_id' => $evento->local_id, // El local será el mismo que el evento
                    'evento_id' => $evento->id, // ID del evento creado
                    'plan_id' => null, // Si el plan es null, se asigna null
                    'numero_asiento' => $i, // Número de asiento
                    'estado' => 'disponible', // Estado inicial del asiento
                ]);
            }
            
            return redirect()->route('eventos.index')->with('success', 'Evento creado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al guardar el evento: ' . $e->getMessage());
            dd($e->getMessage());  // Mostrar mensaje de error
        }
    }

    public function edit($id): View
    {
        $evento = M_Eventos::findOrFail($id);
        $users = User::all();
        $locales = M_Locales::all();

        return view('layouts.eventos.V_editarevento', compact('evento', 'users', 'locales'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required|integer',
                'local_id' => 'required|exists:locales,id',
                'nombre' => 'required|string|max:255',
                'descripcion' => 'nullable|string',
                'fecha_inicio' => 'required|date|before_or_equal:fecha_fin',
                'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
                'fecha_evento' => 'required|date|after_or_equal:fecha_fin',
                'aforo_evento' => 'required|integer',
                'estado' => 'required|in:ACTIVO,CANCELADO,FINALIZADO',
                'Foto' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg,avif|max:2048',
            ]);

            //dd($request->all());

            $evento = M_Eventos::findOrFail($id);

            if ($request->hasFile('Foto')) {
                $path = $request->file('Foto')->store('eventos', 'public');
                $validated['Foto'] = $path;
            }

            $evento->update($validated);


            // Obtener los asientos existentes para este evento
            $asientosExistentes = M_Asientos::where('evento_id', $evento->id)->get();
            $asientosExistentesCount = $asientosExistentes->count();
            $nuevoAforo = $request->aforo_evento;

            // Si el aforo ha disminuido, eliminar los asientos extras
            if ($nuevoAforo < $asientosExistentesCount) {
                $asientosAEliminar = $asientosExistentes->slice($nuevoAforo);
                foreach ($asientosAEliminar as $asiento) {
                    $asiento->delete();
                }
            }

            // Si el aforo ha aumentado, agregar los nuevos asientos
            for ($i = $asientosExistentesCount + 1; $i <= $nuevoAforo; $i++) {
                M_Asientos::create([
                    'local_id' => $evento->local_id, // El local será el mismo que el evento
                    'evento_id' => $evento->id, // ID del evento actualizado
                    'plan_id' => null, // Si el plan es null, se asigna null
                    'numero_asiento' => $i, // Número de asiento
                    'estado' => 'disponible', // Estado inicial del asiento
                ]);
            }

            return redirect()->route('eventos.index')->with('success', 'Evento actualizado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al actualizar el evento: ' . $e->getMessage());
            return redirect()->route('eventos.index')->with('error', 'Error al actualizar el evento.');
        }
    }

    public function destroy($id): RedirectResponse
    {
        try {
            $evento = M_Eventos::findOrFail($id);
            $evento->delete();

            return redirect()->route('eventos.index')->with('success', 'Evento eliminado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar el evento: ' . $e->getMessage());
            return redirect()->route('eventos.index')->with('error', 'Error al eliminar el evento.');
        }
    }
}
