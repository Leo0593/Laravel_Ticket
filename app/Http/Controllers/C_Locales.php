<?php

namespace App\Http\Controllers;

use App\Models\M_Locales;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

use Illuminate\Support\Facades\Log;

class C_Locales extends Controller
{
    // Mostrar todos los locales
    public function index(Request $request): View
    {
        // Obtener el valor de 'orderBy' desde la solicitud, con valor por defecto 'nombre'
        $orderBy = $request->input('orderBy', 'nombre');

        // Obtener el valor de 'showWithoutSeats' desde la solicitud (por defecto '0')
        //$showWithoutSeats = $request->input('showWithoutSeats', '0');
        $asientos = $request->input('asientos');

        // Inicializar la consulta de locales
        $query = M_Locales::query();

        // Aplicar filtro de asientos (solo si se selecciona una opción)
        if ($asientos !== null) {
            if ($asientos == '1') {
                $query->where('Tiene_Asientos', false); // Mostrar locales sin asientos
            } elseif ($asientos == '0') {
                $query->where('Tiene_Asientos', true); // Mostrar locales con asientos
            }
            // Si es "Todos", no se aplica ningún filtro
        }

        // Aplicar filtro y orden según el parámetro 'orderBy'
        switch ($orderBy) {
            case 'nombre':
                $query->orderBy('Nombre');
                break;
            case 'aforo':
                $query->orderBy('Aforo');
                break;
            case 'ubicacion':
                $query->orderBy('Direccion');
                break;
            default:
                $query->orderBy('Nombre'); // Orden por defecto
                break;
        }

        // Obtener los locales filtrados y ordenados
        $locales = $query->get();

        // Verificar si no hay locales
        $noLocales = $locales->isEmpty();

        // Pasar los locales y la variable 'noLocales' a la vista
        return view('layouts.locales.V_todoslocales', compact('locales', 'noLocales'));

        /*
        // Obtener todos los locales
        $locales = M_Locales::all(); // Asegúrate de usar M_Locales
        
        // Verificar si no hay locales
        $noLocales = $locales->isEmpty();

        // Pasar los locales y la variable 'noLocales' a la vista
        return view('layouts.locales.V_todoslocales', compact('locales', 'noLocales'));*/
    }

    public function create(): View
    {
        // Retornar la vista con el formulario de agregar local
        return view('layouts.locales.V_agregarlocal'); // Apunta a la ruta correcta de la vista
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'Nombre' => 'required|string|max:255',
                'Descripcion' => 'nullable|string',
                'Direccion' => 'required|string|max:255',
                'Telefono' => 'nullable|string|max:15',
                'Aforo' => 'required|integer',
                'Tiene_Asientos' => 'nullable|boolean', // Asegúrate de que esté validado correctamente
                'Foto' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048', // Validar que sea una imagen
            ]);

            $request->merge([
                'Tiene_Asientos' => $request->has('Tiene_Asientos') ? 1 : 0
            ]);

            if ($request->hasFile('Foto')) {
                $path = $request->file('Foto')->store('locales', 'public');
                //dd($path);
            } else {
                $path = null;
            }
            
            //dd($validated);

            $validated['Foto'] = $path;

            M_Locales::create($validated);

            return redirect()->route('locales.index')->with('success', 'Local agregado con éxito');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    // Mostrar el formulario para editar un local
    public function edit($id): View
    {
        // Buscar el local por su ID
        $local = M_Locales::findOrFail($id);

        // Pasar el local a la vista
        return view('layouts.locales.V_editarlocal', compact('local'));
    }

    // Actualizar los datos del local
    public function update(Request $request, $id): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'Nombre' => 'required|string|max:255',
                'Descripcion' => 'nullable|string',
                'Direccion' => 'required|string|max:255',
                'Telefono' => 'nullable|string|max:15',
                'Aforo' => 'required|integer',
                'Tiene_Asientos' => 'nullable|boolean',
                'Foto' => $request->hasFile('Foto') ? 'image|mimes:jpg,jpeg,png,gif,svg|max:2048' : 'nullable', // Validación condicional
            ]);

            //dd($request->all()); 
            //dd('Datos validados:', $validated);
            //dd($request->file('Foto')); 
            //Log::debug('Datos validados:', $validated);

            $local = M_Locales::findOrFail($id);

            // Si se sube una nueva foto
            if ($request->hasFile('Foto')) {
                Log::debug('Tipo MIME de la foto: ' . $request->file('Foto')->getClientMimeType());  // Verifica el tipo MIME
                // Subir la foto y obtener la ruta
                $path = $request->file('Foto')->store('locales', 'public');
                Log::debug('Ruta de la foto subida: ' . $path);  // Verifica la ruta de la foto subida
            } else {
                // Mantener la foto actual si no se sube una nueva
                $path = $local->Foto;
                Log::debug('Manteniendo la foto actual: ' . $path);
            }

            $local->update([
                'Nombre' => $request->Nombre,
                'Descripcion' => $request->Descripcion,
                'Direccion' => $request->Direccion,
                'Telefono' => $request->Telefono,
                'Aforo' => $request->Aforo,
                'Tiene_Asientos' => $request->Tiene_Asientos ? 1 : 0,  // Esto maneja el valor correctamente
                'Foto' => $path,  // Guardar la ruta de la foto
            ]);
    
            return redirect()->route('locales.index')->with('success', 'Local actualizado con éxito');
        } catch (\Exception $e) {
            Log::error('Error al actualizar el local: ' . $e->getMessage());
            return back()->with('error', 'Hubo un problema al actualizar el local: ' . $e->getMessage());
        }
    }

    public function ocultar($id): RedirectResponse
    {
        try {
            // Buscar el evento por su ID
            $evento = M_Locales::findOrFail($id);
        
            // Cambiar el valor de 'visible' a 0 para ocultar el evento
            $evento->visible = 0;
            $evento->save(); // Guardar los cambios
        
            // Redirigir con mensaje de éxito
            return redirect()->route('locales.index')->with('success', 'Local ocultado exitosamente.');
        } catch (\Exception $e) {
            // Si hay un error, lo registramos y mostramos un mensaje de error
            Log::error('Error al ocultar el evento: ' . $e->getMessage());
            return redirect()->route('locales.index')->with('error', 'Error al ocultar el local.');
        }
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
