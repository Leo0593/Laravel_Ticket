<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Planes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold" style="font-size: 1.8rem; margin-bottom: 30px">{{ __('Agregar un nuevo plan') }}</h3>
                        
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                    <form method="POST" action="{{ route('planes.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Evento -->
                        <div class="mt-4">
                            <label for="evento_id" class="block text-sm font-medium text-gray-700">{{ __('Evento') }}</label>
                            <input type="text" id="evento_id" name="evento_id" value="{{ old('evento_id') }}" class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:focus:ring-indigo-500 dark:focus:border-indigo-500">
                        </div>
                        
                        <!-- Tipo -->
                        <label for="tipo" class="block text-sm font-medium text-gray-700">{{ __('Tipo de plan') }}</label>
                        <select id="tipo" name="tipo" class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:focus:ring-indigo-500 dark:focus:border-indigo-500">
                            <option value="General" {{ old('tipo') == 'General' ? 'selected' : '' }}>General</option>
                            <option value="VIP" {{ old('tipo') == 'VIP' ? 'selected' : '' }}>VIP</option>
                        </select>
                        
                        <!-- Precio -->
                        <div class="mt-4">
                            <label for="precio" class="block text-sm font-medium text-gray-700">{{ __('Precio') }}</label>
                            <input type="text" id="precio" name="precio" value="{{ old('precio') }}" class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:focus:ring-indigo-500 dark:focus:border-indigo-500">
                        </div>

                        <!-- Descripción -->
                        <div class="mt-4">
                            <label for="descripcion" class="block text-sm font-medium text-gray-700">{{ __('Descripción') }}</label>
                            <textarea id="descripcion" name="descripcion" rows="3" class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:focus:ring-indigo-500 dark:focus:border-indigo-500">{{ old('descripcion') }}</textarea>
                        </div>

                        <!-- Foto -->
                        <div>
                            <label  style="margin-right: 10px"
                            for="Foto">{{ __('Foto del Plan:') }}</label>
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
