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
                    @if(session('success'))
                        <div class="bg-green-500 text-white p-3 rounded-md mb-4">
                            {{ session('success') }}
                        </div>
                    @endif


                    @if($noPlanes)
                        <p>{{ __('No hay planes') }}</p>
                    @else
                        <table class="min-w-full bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600">{{ __('id') }}</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600">{{ __('evento_id') }}</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600">{{ __('Tipo') }}</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600">{{ __('Precio') }}</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600">{{ __('Descripción') }}</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600">{{ __('Foto') }}</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600">{{ __('Acciones') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($planes as $plan)
                                    <tr>
                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">{{ $plan->id }}</td>
                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">{{ $plan->evento_id }}</td>
                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">{{ $plan->tipo }}</td>
                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">{{ $plan->precio }}</td>
                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">{{ $plan->descripcion }}</td>

                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                                            @if($plan->Foto)
                                                <img src="{{ asset('storage/' . $plan->Foto) }}" alt="Foto del plan" class="w-20 h-20 object-cover rounded-md">
                                            @else
                                                {{ __('No disponible') }}
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">

                                            <!-- Botón de Editar -->
                                            <a href="{{ route('planes.edit', $plan->id) }}" 
                                                class="text-blue-500 hover:text-blue-700" 
                                                style="margin-right: 10px;">
                                                {{ __('Editar') }}
                                            </a>

                                            <!-- Botón de Eliminar -->
                                            <form action="{{ route('planes.destroy', $plan->id) }}" method="POST" class="inline-block">
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