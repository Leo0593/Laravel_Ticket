<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Plan') }}
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

                    <form action="{{ route('planes.update', $plan->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Evento -->
                        <div>
                            <label for="evento_id">{{ __('Evento') }}</label>
                            <select id="evento_id" name="evento_id" class="form-control" required>
                                @foreach($eventos as $evento)
                                    <option value="{{ $evento->id }}" {{ old('evento_id', $plan->evento_id) == $evento->id ? 'selected' : '' }}>
                                        {{ $evento->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('evento_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tipo -->
                        <div>
                            <label for="tipo">{{ __('Tipo de Plan') }}</label>
                            <select id="tipo" name="tipo" class="form-control" required>
                                <option value="General" {{ old('tipo', $plan->tipo) == 'General' ? 'selected' : '' }}>General</option>
                                <option value="VIP" {{ old('tipo', $plan->tipo) == 'VIP' ? 'selected' : '' }}>VIP</option>
                            </select>
                            @error('tipo')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Precio -->
                        <div>
                            <label for="Precio">{{ __('Precio') }}</label>
                            <input type="text" id="precio" name="precio" value="{{ old('precio', $plan->precio) }}" required>
                        </div>

                        <!-- Descripción -->
                        <div> 
                            <label for="Descripcion">{{ __('Descripción') }}</label>
                            <textarea id="descripcion" name="descripcion">{{ old('descripcion', $plan->descripcion) }}</textarea>
                        </div>

                        <!-- Foto -->
                        <div>
                            <label for="Foto">{{ __('Foto del Plan') }}</label>
                            <input type="file" id="Foto" name="Foto">
                            @if ($plan->Foto)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/'.$plan->Foto) }}" alt="Foto del plan" width="100">
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
