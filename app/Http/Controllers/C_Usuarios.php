<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class C_Usuarios extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $users = User::all();
        $noUser = $users->isEmpty();

        return view('layouts.users.V_todosusuarios', compact('users', 'noUser'));
    }

    public function create(): View
    {
        return view('layouts.users.V_crearusuario');
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'phone' => 'required|string|max:255',
                'password' => 'required|string|min:8',
                'role' => ['required', Rule::in(['USER', 'GESTOR', 'ADMIN'])], // Asegura que el rol sea válido
                'Foto' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg,webp,avif|max:2048',
            ]);

            $validated['password'] = Hash::make($validated['password']);

            // Manejo de imagen si se sube
            if ($request->hasFile('Foto')) {
                $path = $request->file('Foto')->store('users', 'public');
            } else {
                $path = null;
            }

            $validated['Foto'] = $path;

            User::create($validated);

            return redirect()->route('users.index')->with('success', 'Usuario creado correctamente.');

        } catch (\Exception $e) {
            dd($e);
            Log::error('Error al crear usuario: ' . $e->getMessage());
            return redirect()->route('users.index');
        }
    }

    public function edit($id): View
    {
        $user = User::find($id);

        return view('layouts.users.V_editarusuario', compact('user'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'phone' => 'required|string|max:255',
                'role' => ['required', Rule::in(['USER', 'GESTOR', 'ADMIN'])], // Asegura que el rol sea válidoß
                'estado' => 'required|in:0,1',                  
                'Foto' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg,avif,webp|max:2048',
            ]);

            $user = User::findOrFail($id);  // Asegúrate de que el usuario existe

            if ($request->hasFile('Foto')) {
                $path = $request->file('Foto')->store('users', 'public');
                $validated['Foto'] = $path;
            } else {
                $validated['Foto'] = $user->Foto;
            }


            $user->update($validated);

            return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente');
        } catch (\Exception $e) {
            Log::error('Error al actualizar usuario: ' . $e->getMessage());
            return redirect()->route('users.index');
        }   
    }

    public function destroy($id): RedirectResponse
    {
        try {
            // Intenta obtener al usuario
            $user = User::findOrFail($id);
    
            // Elimina al usuario
            $user->delete();
    
            // Mensaje flash de éxito
            return redirect()->route('users.index')->with('success', 'Usuario eliminado correctamente.');
        } catch (\Exception $e) {
            // Si ocurre un error, captura la excepción y guarda el error en el log
            Log::error('Error al eliminar usuario: ' . $e->getMessage());
    
            // Retorna a la lista de usuarios con mensaje de error
            return redirect()->route('users.index')->with('error', 'Hubo un problema al eliminar el usuario.');
        }
    }

    public function ocultar($id): RedirectResponse
    {
        try {
            // Intenta obtener al usuario
            $user = User::findOrFail($id);
    
            // Cambia el estado del usuario
            $user->estado = !$user->estado;
    
            // Guarda el usuario
            $user->save();
    
            // Mensaje flash de éxito
            return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente.');
        } catch (\Exception $e) {
            // Si ocurre un error, captura la excepción y guarda el error en el log
            Log::error('Error al actualizar usuario: ' . $e->getMessage());
    
            // Retorna a la lista de usuarios con mensaje de error
            return redirect()->route('users.index')->with('error', 'Hubo un problema al actualizar el usuario.');
        }
    }
}
