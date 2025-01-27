<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Locales') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold"  style="font-size: 1.8rem; margin-bottom: 30px">{{ __('Agregar un nuevo local') }}</h3>
                    
                    <form method="POST" action="{{ route('locales.store') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Nombre -->
                        <div class="mb-4">
                            <label for="Nombre" class="block text-sm font-medium text-gray-700">{{ __('Nombre del local') }}</label>
                            <input type="text" name="Nombre" id="Nombre" 
                            class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                            required>
                        </div>

                        <!-- Descripción -->
                        <div class="mb-4">
                            <label for="Descripcion" class="block text-sm font-medium text-gray-700">{{ __('Descripción del local') }}</label>
                            <textarea name="Descripcion" id="Descripcion" 
                            class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                            ></textarea>
                        </div>

                        <!-- Dirección -->
                        <div class="mb-4">
                            <label for="Direccion" class="block text-sm font-medium text-gray-700">{{ __('Dirección') }}</label>
                            <input type="text" name="Direccion" id="Direccion" 
                            class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                            required>
                        </div>

                        <div class="mb-4">
                            <label for="Telefono" class="block text-sm font-medium text-gray-700">{{ __('Teléfono') }}</label>
                            <input type="text" name="Telefono" id="Telefono" 
                            class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                            >
                        </div>

                        <!-- Aforo -->
                        <div class="mb-4">
                            <label for="Aforo" class="block text-sm font-medium text-gray-700">{{ __('Aforo') }}</label>
                            <input type="number" name="Aforo" id="Aforo" 
                            class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                            required>
                        </div>

                        <!-- Tiene_Asientos -->
                        <div class="mb-4">
                            <label for="Tiene_Asientos" class="inline-flex items-center">
                                <input type="checkbox" id="Tiene_Asientos" name="Tiene_Asientos" value="1"><br><br>
                                <span style="margin-left: 10px">{{ __('¿Tiene asientos?') }}</span>
                            </label>
                        </div>

                        <!-- Foto -->
                        <div>
                            <label style="margin-right: 10px"
                            for="Foto">{{ __('Foto del Local:') }}</label>
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
