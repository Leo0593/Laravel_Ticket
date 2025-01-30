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
                    
                    @if(session('success'))
                        <div class="bg-green-500 text-white p-3 rounded-md mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($noAsientos)
                        <p>{{ __('No hay asientos') }}</p>
                    @else
                        <table class="min-w-full bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600" scope="col">{{ __('ID') }}</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600" scope="col">{{ __('Local_id') }}</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600" scope="col">{{ __('Evento_id') }}</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600" scope="col">{{ __('Plan_id') }}</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600" scope="col">{{ __('Tipo') }}</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600" scope="col">{{ __('Número Asiento') }}</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600" scope="col">{{ __('Estado') }}</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600" scope="col">{{ __('Acciones') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($asientos as $asiento)
                                    <tr>
                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">{{ $asiento->id }}</td>
                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">{{ $asiento->local_id }}</td>
                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">{{ $asiento->evento_id }}</td>
                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">{{ $asiento->plan_id }}</td>
                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">{{ $asiento->tipo }}</td>
                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">{{ $asiento->numero_asiento }}</td>
                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">{{ $asiento->estado }}</td>

                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">

                                            <!-- Botón de Editar -->
                                            <a href="{{ route('asientos.edit', $asiento->id) }}" 
                                                class="text-blue-500 hover:text-blue-700" 
                                                style="margin-right: 10px;">
                                                {{ __('Editar') }}
                                            </a>

                                            <br>

                                            <!-- Botón de Eliminar -->
                                            <form action="{{ route('asientos.destroy', $asiento->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 ml-4" 
                                                    onclick="return confirm('¿Estás seguro de que deseas eliminar este local?')">
                                                    {{ __('Eliminar') }}
                                                </button>
                                            </form>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>