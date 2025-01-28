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
                    
                    @if(session('success'))
                        <div class="bg-green-500 text-white p-3 rounded-md mb-4">
                            {{ session('success') }}
                        </div>
                    @endif


                    @if($noLocales)
                        <p>{{ __('No hay locales') }}</p>
                    @else
                        <table class="min-w-full bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600">{{ __('id') }}</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600">{{ __('Nombre') }}</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600">{{ __('Descripción') }}</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600">{{ __('Dirección') }}</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600">{{ __('Teléfono') }}</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600">{{ __('Aforo') }}</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600">{{ __('Asientos') }}</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600">{{ __('Foto') }}</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600">{{ __('Acciones') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($locales as $local)
                                    <tr>
                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">{{ $local->id }}</td>
                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">{{ $local->Nombre }}</td>
                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">{{ $local->Descripcion }}</td>
                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">{{ $local->Direccion }}</td>
                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">{{ $local->Telefono }}</td>
                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">{{ $local->Aforo }}</td>

                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                                            {{ $local->Tiene_Asientos ? 'Tiene Asientos' : 'No tiene Asientos' }}
                                        </td>

                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                                            @if($local->Foto)
                                                <img src="{{ asset('storage/' . $local->Foto) }}" alt="Foto del local" class="w-20 h-20 object-cover rounded-md">
                                            @else
                                                {{ __('No disponible') }}
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                                            
                                            <!-- Botón de Editar -->
                                            <a href="{{ route('locales.edit', $local->id) }}" 
                                                class="text-blue-500 hover:text-blue-700" 
                                                style="margin-right: 10px;">
                                                {{ __('Editar') }}
                                            </a>

                                            <!-- Botón de Eliminar -->
                                            <form action="{{ route('locales.destroy', $local->id) }}" method="POST" class="inline-block">
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
                    <!--
                    @if($noLocales)
                        <p>{{ __('No hay locales') }}</p>
                    @else
                        <ul>
                            @foreach($locales as $local)
                                <li>
                                    <strong>{{ $local->Nombre }}</strong><br>
                                    {{ $local->Descripcion }}<br>
                                    {{ $local->Direccion }}<br>
                                    {{ $local->Telefono }}<br>
                                    {{ $local->Aforo }}<br>
                                    {{ $local->Tiene_Asientos ? 'Tiene Asientos' : 'No tiene Asientos' }}<br>
                                </li>
                            @endforeach
                        </ul>
                    @endif -->
                </div>
            </div>
        </div>
    </div>
</x-app-layout>