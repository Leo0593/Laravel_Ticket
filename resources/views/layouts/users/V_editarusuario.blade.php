<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Usuario') }}
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

                    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Nombre -->
                        <div>
                            <label for="name">Nombre</label>
                            <input type="text" id="name" name="name" value="{{ old('nombre', $user->name) }}" required>
                        </div>

                        <!-- Apellido -->
                        <div>
                            <label for="last_name">Apellido</label>
                            <input type="text" id="last_name" name="last_name" value="{{ old('apellido', $user->last_name) }}" required>
                        </div>

                        <!-- Teléfono -->
                        <div>
                            <label for="phone">Teléfono</label>
                            <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        </div>

                        <!-- Estado -->
                        <div>
                            <label for="email">Email</label>
                            <select name="estado" id="estado">
                                <option value="1" {{ old('estado', $user->estado) == 1 ? 'selected' : '' }}>Activo</option>
                                <option value="0" {{ old('estado', $user->estado) == 0 ? 'selected' : '' }}>Inactivo</option>
                            </select>
                        </div> 
                        
                        <!-- Foto -->                        
                        <div>
                            <label for="Foto">{{ __('Foto del Evento') }}</label>
                            <input type="file" id="Foto" name="Foto">
                            @if ($user->Foto)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/'.$user->Foto) }}" alt="Foto" width="100">
                                    <p class="text-sm text-gray-500">{{ __('Si no deseas cambiar la foto, deja el campo vacío.') }}</p>
                                </div>
                            @endif
                        </div>

                        <div>
                            <button id="btn_agregar" type="submit">Actualizar Evento</button>
                        </div>
                       
                    </form>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>
