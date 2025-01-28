<?php

namespace App\Http\Controllers;

use App\Models\M_Plan;
use Illuminate\Http\Request;

class C_Plan extends Controller
{
    public function index()
    {
        $planes = M_Plan::all();
        $noPlanes = $planes->isEmpty();

        return view('layouts.planes.V_todosplans', compact('planes', 'noPlanes'));
    }

    public function create()
    {
        return view('layouts.planes.V_agregarplan');
    }

    public function store(Request $request)
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
}
