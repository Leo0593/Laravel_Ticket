<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Asientos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold" style="font-size: 1.8rem; margin-bottom: 30px">{{ __('Agregar un nuevo asiento') }}</h3>
                    
                    <form method="POST" action="{{ route('asientos.store') }}">
                        @csrf
                        
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

                        <!-- Evento -->
                        <div class="mb-4">
                            <label for="evento_id" class="block text-sm font-medium text-gray-700">{{ __('Evento') }}</label>
                            <select name="evento_id" id="evento_id" 
                            class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                            required>
                                @foreach($eventos as $evento)
                                    <option value="{{ $evento->id }}">{{ $evento->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Plan -->
                        <div class="mb-4">
                            <label for="plan_id" class="block text-sm font-medium text-gray-700">{{ __('Plan') }}</label>
                            <select name="plan_id" id="plan_id" 
                            class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                            required>
                                @foreach($planes as $plan)
                                    <option value="{{ $plan->id }}">{{ $plan->tipo }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tipo de Asiento -->
                        <div class="mb-4">
                            <label for="tipo" class="block text-sm font-medium text-gray-700">{{ __('Tipo de asiento') }}</label>
                            <select name="tipo" id="tipo" 
                            class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                            required>
                                <option value="Individual">{{ __('Individual') }}</option>
                                <option value="Doble">{{ __('Doble') }}</option>
                                <option value="VIP">{{ __('VIP') }}</option>
                            </select>
                        </div>

                        <!-- Número de Asiento -->
                        <div class="mb-4">
                            <label for="numero_asiento" class="block text-sm font-medium text-gray-700">{{ __('Número de Asiento') }}</label>
                            <input type="text" name="numero_asiento" id="numero_asiento" 
                            class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                            required>
                        </div>

                        <!-- Estado -->
                        <div class="mb-4">
                            <label for="estado" class="block text-sm font-medium text-gray-700">{{ __('Estado del asiento') }}</label>
                            <select name="estado" id="estado" 
                            class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                            required>
                                <option value="Disponible">{{ __('Disponible') }}</option>
                                <option value="Ocupado">{{ __('Ocupado') }}</option>
                                <option value="Reservado">{{ __('Reservado') }}</option>
                            </select>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">
                                {{ __('Agregar') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
