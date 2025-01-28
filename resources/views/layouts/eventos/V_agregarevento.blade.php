<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Eventos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold" style="font-size: 1.8rem; margin-bottom: 30px">{{ __('Agregar un nuevo plan') }}</h3>
                        
                    <!-- ERROR -->
                    <form method="POST" action="{{ route('eventos.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Usuario -->
                        <div class="mb-4">
                            <label for="user_id" class="block text-sm font-medium text-gray-700">{{ __('Usuario') }}</label>
                            <select name="user_id" id="user_id" 
                            class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                            required>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Local -->
                        <div class="mb-4">
                            <label for="local_id" class="block text-sm font-medium text-gray-700">{{ __('Local') }}</label>
                            <select name="local_id" id="local_id" 
                            class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                            required>
                                @foreach($locales as $local)
                                    <option value="{{ $local->id }}">{{ $local->Nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Fecha_inicio -->
                        <div class="mb-4">
                            <label for="fecha_inicio" class="block text-sm font-medium text-gray-700">{{ __('Fecha de inicio') }}</label>
                            <input type="date" name="fecha_inicio" id="fecha_inicio"
                            class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                            required>
                        </div>

                        <!-- Fecha_fin -->
                        <div class="mb-4">
                            <label for="fecha_fin" class="block text-sm font-medium text-gray-700">{{ __('Fecha de fin') }}</label>
                            <input type="date" name="fecha_fin" id="fecha_fin" 
                            class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                            required>
                        </div>

                        <!-- Fecha_limite -->
                        <div class="mb-4">
                            <label for="fecha_evento" class="block text-sm font-medium text-gray-700">{{ __('Fecha límite') }}</label>
                            <input type="date" name="fecha_evento" id="fecha_evento" 
                            class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                            required>
                        </div>

                        <!-- Aforo -->
                        <div class="mb-4">
                            <label for="aforo_evento" class="block text-sm font-medium text-gray-700">{{ __('Aforo') }}</label>
                            <input type="number" name="aforo_evento" id="aforo_evento" 
                            class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                            required>
                        </div>

                        <!-- Estado -->
                        <select name="estado" id="estado" 
                        class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                        required>
                            <option value="ACTIVO" {{ old('estado') == 'ACTIVO' ? 'selected' : '' }}>{{ __('Activo') }}</option>
                            <option value="CANCELADO" {{ old('estado') == 'CANCELADO' ? 'selected' : '' }}>{{ __('Cancelado') }}</option>
                            <option value="FINALIZADO" {{ old('estado') == 'FINALIZADO' ? 'selected' : '' }}>{{ __('Finalizado') }}</option>
                        </select>

                        <br>
                        <!-- Foto -->
                        <div>
                            <label  style="margin-right: 10px"
                            for="Foto">{{ __('Foto del Evento:') }}</label>
                            <input type="file" id="Foto" name="Foto">
                        </div>

                        <div class="mt-6">
                            <button type="submit">
                                {{ __('Agregar') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>