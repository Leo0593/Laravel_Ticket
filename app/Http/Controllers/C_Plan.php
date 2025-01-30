<?php

namespace App\Http\Controllers;

use App\Models\M_Plan;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Console;

use App\Models\M_Eventos;

class C_Plan extends Controller
{
    public function index(): View
    {
        $planes = M_Plan::all();
        $noPlanes = $planes->isEmpty();

        return view('layouts.planes.V_todosplans', compact('planes', 'noPlanes'));
    }

    public function create(): View
    {
        $eventos = M_Eventos::all();

        return view('layouts.planes.V_agregarplan', compact('eventos'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'evento_id' => 'required|integer',
            'tipo' => 'required|in:General,VIP',
            'precio' => 'required|numeric',
            'descripcion' => 'nullable|string',
            'Foto' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
        ]);

        if ($request->hasFile('Foto')) {
            $path = $request->file('Foto')->store('plans', 'public');
        } else {
            $path = null;
        }

        M_Plan::create([
            'evento_id' => $request->evento_id,
            'tipo' => $request->tipo,
            'precio' => $request->precio,
            'descripcion' => $request->descripcion,
            'Foto' => $path,
        ]);

        return redirect()->route('planes.index');
    }

    public function edit(int $id): View
    {
        $plan = M_Plan::findOrFail($id);
        $eventos = M_Eventos::all();

        return view('layouts.planes.V_editarplan', compact('plan', 'eventos'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'evento_id' => 'required|integer',
                'tipo' => 'required|in:General,VIP',
                'precio' => 'required|numeric',
                'descripcion' => 'nullable|string',
                'Foto' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
            ]);

            
            //dd($request->all());

            $plan = M_Plan::findOrFail($id);

            if ($request->hasFile('Foto')) {
                $path = $request->file('Foto')->store('plans', 'public');
                $validated['Foto'] = $path;
            }

            $plan->update($validated);
    
            return redirect()->route('planes.index')->with('success', 'Plan actualizado exitosamente.');
        } 
        catch (\Exception $e) {
            dd('Error al actualizar el plan:', $e->getMessage());
            ///Log::error(Error al actualizar el plan: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ocurrió un error al actualizar el plan');
        }        
    }

    public function destroy(int $id): RedirectResponse
    {
        try {
            $plan = M_Plan::findOrFail($id);
            $plan->delete();

            return redirect()->route('planes.index')->with('success', 'Plan eliminado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar el plan: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ocurrió un error al eliminar el plan');
        }
    }

    public function getPlanesByEvento($eventoId)
    {
        $planes = M_Plan::where('Evento_id', $eventoId)->get();
    
        return response()->json([
            'planes' => $planes,
            'message' => $planes->isEmpty() ? 'No hay planes disponibles' : 'Planes encontrados'
        ]);
    }    
}
