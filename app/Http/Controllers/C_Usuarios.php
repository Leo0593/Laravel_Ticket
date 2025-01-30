<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

use Illuminate\Support\Facades\Log;

class C_Usuarios extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $users = User::paginate(10);
        $noUser = $users->isEmpty();

        return view('layouts.users.V_todosusuarios', compact('users', 'noUser'));
    }

    public function edit($id): View
    {
        $user = User::find($id);

        return view('layouts.users.V_editarusuario', compact('user'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        try {
            $user = User::findOrFail($id);  // Asegúrate de que el usuario existe

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'phone' => 'required|string|max:255',
                'estado' => 'required|in:0,1',                  
                'Foto' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
            ]);

            //dd($request->estado);

            if ($validator->fails()) {
                return redirect()->route('users.edit', $id)
                    ->withErrors($validator)
                    ->withInput();
            }
            // Actualiza los campos del usuario
            $user->name = $request->name;
            $user->last_name = $request->last_name; // Asegúrate de que este campo está presente en tu formulario
            $user->email = $request->email;
            $user->phone = $request->phone; // Asegúrate de que este campo también está en el formulario
            $user->estado = (int) $request->estado; // Asegúrate de que este campo también está en el formulario

            if ($request->password) {
                $user->password = Hash::make($request->password);
            }

            if ($request->hasFile('Foto')) {
                $path = $request->file('Foto')->store('users', 'public');
                $user->Foto = $path;  // Guarda la ruta de la imagen en el campo 'Foto'
            }

            $user->save();
    
            return redirect()->route('users.index');
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
}
