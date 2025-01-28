<?php

namespace App\Http\Controllers;

use App\Models\M_Locales;
use Illuminate\Http\Request;

class C_Locales extends Controller
{
    // Mostrar todos los locales
    public function index()
    {
        // Obtener todos los locales
        $locales = M_Locales::all(); // Asegúrate de usar M_Locales
        
        // Verificar si no hay locales
        $noLocales = $locales->isEmpty();

        // Pasar los locales y la variable 'noLocales' a la vista
        return view('layouts.locales.V_todoslocales', compact('locales', 'noLocales'));
    }

    public function create()
    {
        // Retornar la vista con el formulario de agregar local
        return view('layouts.locales.V_agregarlocal'); // Apunta a la ruta correcta de la vista
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'Nombre' => 'required|string|max:255',
            'Descripcion' => 'nullable|string',
            'Direccion' => 'required|string|max:255',
            'Telefono' => 'nullable|string|max:15',
            'Aforo' => 'required|integer',
            'Tiene_Asientos' => 'nullable|boolean', // Asegúrate de que esté validado correctamente
            'Foto' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048', // Validar que sea una imagen
        ]);

        // Asignar un valor de 0 si el checkbox no está marcado
        $request->merge([
            'Tiene_Asientos' => $request->has('Tiene_Asientos') ? 1 : 0
        ]);

        // Subir la foto si existe
        if ($request->hasFile('Foto')) {
            // Subir la imagen y obtener su ruta
            $path = $request->file('Foto')->store('locales', 'public');  // Guardar en la carpeta 'locales' dentro de 'storage/app/public'
        } else {
            $path = null;  // Si no se sube una foto, mantener el valor en null
        }

        // Crear el nuevo local con los datos validados
        M_Locales::create([
            'Nombre' => $request->Nombre,
            'Descripcion' => $request->Descripcion,
            'Direccion' => $request->Direccion,
            'Telefono' => $request->Telefono,
            'Aforo' => $request->Aforo,
            'Tiene_Asientos' => $request->Tiene_Asientos,
            'Foto' => $path,  // Guardar la ruta de la foto
        ]);

        // Redirigir a la vista de todos los locales con un mensaje de éxito
        return redirect()->route('locales.index')->with('success', 'Local agregado con éxito');
    }

    // Mostrar el formulario para editar un local
    public function edit($id)
    {
        // Buscar el local por su ID
        $local = M_Locales::findOrFail($id);

        // Pasar el local a la vista
        return view('layouts.locales.V_editarlocal', compact('local'));
    }

    // Actualizar los datos del local
    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'Nombre' => 'required|string|max:255',
            'Descripcion' => 'nullable|string',
            'Direccion' => 'required|string|max:255',
            'Telefono' => 'nullable|string|max:15',
            'Aforo' => 'required|integer',
            'Tiene_Asientos' => 'nullable|boolean',
            'Foto' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048', // Validar que sea una imagen
        ]);

        // Buscar el local por su ID
        $local = M_Locales::findOrFail($id);

        // Subir la foto si existe
        if ($request->hasFile('Foto')) {
            // Eliminar la foto anterior si existe
            if ($local->Foto && Storage::exists('public/' . $local->Foto)) {
                Storage::delete('public/' . $local->Foto);
            }

            // Subir la nueva foto
            $path = $request->file('Foto')->store('locales', 'public');  // Guardar en la carpeta 'locales' dentro de 'storage/app/public'
        } else {
            // Mantener la foto actual si no se subió una nueva
            $path = $local->Foto;
        }

        // Actualizar los datos del local
        $local->update([
            'Nombre' => $request->Nombre,
            'Descripcion' => $request->Descripcion,
            'Direccion' => $request->Direccion,
            'Telefono' => $request->Telefono,
            'Aforo' => $request->Aforo,
            'Tiene_Asientos' => $request->Tiene_Asientos ? 1 : 0,  // Esto maneja el valor correctamente
            'Foto' => $path,  // Guardar la ruta de la foto
        ]);

        // Redirigir a la vista de todos los locales con un mensaje de éxito
        return redirect()->route('locales.index')->with('success', 'Local actualizado con éxito');
    }

    // Eliminar un local
    public function destroy($id)
    {
        // Buscar el local por su ID
        $local = M_Locales::findOrFail($id);

        // Eliminar el local
        $local->delete();

        // Redirigir a la vista de todos los locales con un mensaje de éxito
        return redirect()->route('locales.index')->with('success', 'Local eliminado con éxito');
    }
}
