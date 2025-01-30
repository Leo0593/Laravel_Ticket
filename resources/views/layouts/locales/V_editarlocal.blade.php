<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Local') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <!-- Mensaje de error para los campos -->
                    @if ($errors->any())
                        <div>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('locales.update', $local->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Nombre -->
                        <div>
                            <label for="Nombre">{{ __('Nombre') }}</label>
                            <input type="text" id="Nombre" name="Nombre" value="{{ $local->Nombre }}" required>
                        </div>

                        <!-- Otros campos -->
                        <div>
                            <label for="Descripcion">{{ __('Descripción') }}</label>
                            <textarea id="Descripcion" name="Descripcion">
                                {{ $local->Descripcion }}
                            </textarea>
                        </div>

                        <div>
                            <label for="Direccion">{{ __('Dirección') }}</label>
                            <input type="text" id="Direccion" name="Direccion" value="{{ $local->Direccion }}" required>
                        </div>

                        <div>
                            <label for="Telefono">{{ __('Teléfono') }}</label>
                            <input type="text" id="Telefono" name="Telefono" value="{{ $local->Telefono }}">
                        </div>

                        <div>
                            <label for="Aforo">{{ __('Aforo') }}</label>
                            <input type="number" id="Aforo" name="Aforo" value="{{ $local->Aforo }}" required>
                        </div>

                        <!-- Campo oculto para manejar el caso desmarcado -->
                        <input type="hidden" name="Tiene_Asientos" value="0">

                        <div>
                            <label for="Tiene_Asientos">{{ __('Tiene Asientos') }}</label>
                            <input type="checkbox" id="Tiene_Asientos" name="Tiene_Asientos" value="1" {{ $local->Tiene_Asientos ? 'checked' : '' }}>
                        </div>

                        <!-- Foto -->
                        <div>
                            <label for="Foto">{{ __('Foto del Local') }}</label>
                            <input type="file" id="Foto" name="Foto">
                            @if ($local->Foto)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/'.$local->Foto) }}" alt="Foto del local" width="100">
                                    <p class="text-sm text-gray-500">{{ __('Si no deseas cambiar la foto, deja el campo vacío.') }}</p>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Botón de guardar -->
                        <button type="submit">{{ __('Actualizar') }}</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
