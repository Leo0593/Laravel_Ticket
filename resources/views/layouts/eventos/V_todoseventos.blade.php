<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('layouts.head')
    
    <body style="background-color:rgb(255, 255, 255) !important;">
        @include('layouts.header')

        <div class="main">
            <h1 class="mt-4">EVENTOS</h1>

            <div class="main_contenedor">
                <div class="container mt-5">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#eventModal">
                        Crear Evento
                    </button>
                </div>

                <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: #ffc107; align-items: center;">
                                <h5 class="modal-title" id="eventModalLabel"><strong>Crear Evento</strong></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('eventos.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                  
                                    <div class="cont_input_1">
                                        <label for="Nombre">Nombre</label>
                                        <input class="input_1" type="text" id="Nombre" name="Nombre" required>
                                    </div>

                                    <div class="cont_input_1">
                                        <label for="Descripcion">Descripción</label>
                                        <input class="input_1" type="text" id="Descripcion" name="Descripcion" required>
                                    </div>

                                    <div class="cont_input_1">
                                        <label for="Imagen">Imagen</label>
                                        <input class="input_1" type="file" id="Imagen" name="Imagen" required>
                                    </div>

                                    <div class="cont_input_1">
                                        <label for="Compra">Inicio Compra</label>
                                        <input class="input_1" type="date" id="Compra" name="Compra" required>
                                    </div>

                                    <div class="cont_input_1">
                                        <label for="Fin_Compra">Fin Compra</label>
                                        <input class="input_1" type="date" id="Fin_Compra" name="Fin_Compra" required>
                                    </div>

                                    <div class="cont_input_1">
                                        <label for="Fecha_evento">Fecha Evento</label>
                                        <input class="input_1" type="date" id="Fecha_evento" name="Fecha_evento" required>
                                    </div>

                                    <div class="cont_input_1">
                                        <label for="Aforo">Aforo</label>
                                        <input class="input_1" type="number" id="Aforo" name="Aforo" required>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                @foreach($eventos as $evento)
                    <div class="card" style="width: 18rem; box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);">
                        <img class="card-img-top" 
                                src="{{ $evento->Imagen ? asset('storage/' . $evento->Imagen) : 'https://placehold.co/600x400' }}"  
                                alt="Imagen del evento">
                        <div class="card-body">
                            <h5 class="card-title"><strong>{{ $evento->Nombre }}</strong></h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>Descripción: </strong>{{ $evento->descripcion }}</li>
                                <li class="list-group-item"><strong>Inicio Compra: </strong>{{ \Carbon\Carbon::parse($evento->inicio)->format('d/m/Y') }}</li>
                                <li class="list-group-item"><strong>Fin Compra: </strong>{{ \Carbon\Carbon::parse($evento->fecha_fin)->format('d/m/Y') }}</li>
                                <li class="list-group-item"><strong>Fecha Evento: </strong>{{ \Carbon\Carbon::parse($evento->fecha_evento)->format('d/m/Y') }}</li>
                                <li class="list-group-item"><strong>Aforo: </strong>{{ $evento->aforo_evento }}</li>
                            </ul>
                        </div>
                        <div class="card-body d-flex justify-content-around">
                            <a href="{{ route('eventos.edit', $evento->id) }}" class="btn btn-warning">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form action="{{ route('eventos.destroy', $evento->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </body>
</html>

 <!--
 <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Eventos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8" style="width: 1500px">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="text-gray-900 dark:text-gray-100">
                    @if(session('success'))
                        <div class="bg-green-500 text-white p-3 rounded-md mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($noEventos)
                        <p>{{ __('No hay eventos') }}</p>
                    @else
                        <table class="min-w-full bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600">{{ __('id') }}</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600">{{ __('user_id') }}</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600">{{ __('local_id') }}</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600">{{ __('Nombre') }}</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600">{{ __('Descripción') }}</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600">{{ __('Fecha inicio') }}</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600">{{ __('Fecha fin') }}</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600">{{ __('Fecha limite') }}</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600">{{ __('Aforo') }}</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600">{{ __('Estado') }}</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600">{{ __('Foto') }}</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600">{{ __('Acciones') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($eventos as $evento)
                                    <tr>
                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">{{ $evento->id }}</td>
                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">{{ $evento->user_id }}</td>
                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">{{ $evento->local_id }}</td>
                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">{{ $evento->nombre }}</td>
                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">{{ $evento->descripcion }}</td>
                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">{{ $evento->fecha_inicio }}</td>
                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">{{ $evento->fecha_fin }}</td>
                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">{{ $evento->fecha_evento }}</td>
                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">{{ $evento->aforo_evento }}</td>
                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">{{ $evento->estado }}</td>

                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                                            @if($evento->Foto)
                                                <img src="{{ asset('storage/' . $evento->Foto) }}" alt="Foto del evento" class="w-20 h-20 object-cover rounded-md">
                                            @else
                                                {{ __('No disponible') }}
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">

                                            //Botón de Editar
                                            <a href="{{ route('eventos.edit', $evento->id) }}" 
                                                class="text-blue-500 hover:text-blue-700" 
                                                style="margin-right: 10px;">
                                                {{ __('Editar') }}
                                            </a>

                                            <br>

                                            //Botón de Eliminar
                                            <form action="{{ route('eventos.destroy', $evento->id) }}" method="POST" class="inline-block">
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
</x-app-layout> -->