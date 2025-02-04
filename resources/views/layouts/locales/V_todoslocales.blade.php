<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('layouts.head')
    
    <body>
        @include('layouts.header')

        <div class="main">
            <h1 class="mt-4">LOCALIDADES</h1>

            <div class="main_contenedor">
                @if($noLocales)
                    <p>{{ __('No hay locales') }}</p>
                @else
                    @foreach($locales as $local)
                        <div class="card" style="width: 18rem;box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);">
                            <img class="card-img-top" 
                                src="{{ $local->Foto ? asset('storage/' . $local->Foto) : 'https://placehold.co/600x400' }}"  
                                alt="Foto del local">

                            <div class="card-body">
                                <h5 class="card-title"><strong>NOMBRE: </strong>{{ $local->Nombre }}</h5>
                                <p class="card-text"><strong>DESCRIPCIÓN: </strong>{{ $local->Descripcion }}</p>
                                <p class="card-text">{{ $local->Descripción }}</p>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>UBICACIÓN: </strong>{{ $local->Direccion }}</li>
                                <li class="list-group-item"><strong>TELÉFONO: </strong>{{ $local->Teléfono }}</li>
                                <li class="list-group-item"><strong>AFORO: </strong>{{ $local->Aforo }}</li>
                                <li class="list-group-item"><strong>ASIENTOS: </strong>{{ $local->Tiene_Asientos ? 'Tiene Asientos' : 'No tiene Asientos' }}</li>
                            </ul>
                            <div class="card-body d-flex justify-content-around" style="max-height: 78px;">
                                <a href="#" class="btn btn-primary">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('locales.edit', $local->id) }} " class="btn btn-warning">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <a href="#" class="btn btn-danger">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                @endif

                <div class="card" style="width: 18rem;">
                    <img class="card-img-top" src="https://placehold.co/600x400"  alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Nombre</h5>
                        <p class="card-text">Descripcion Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Ubicacion: </li>
                        <li class="list-group-item">Aforo: </li>
                        <li class="list-group-item">Asientos:</li>
                    </ul>
                    <div class="card-body d-flex justify-content-around">
                        <a href="#" class="btn btn-primary">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                        <a href="{{ route('locales.edit', $local->id) }}" class="btn btn-warning">
                            <i class="fa-solid fa-pen"></i>
                        </a>
                        <a href="#" class="btn btn-danger">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Open modal for @mdo</button>
                    </div>
                </div>

                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Recipient:</label>
                                    <input type="text" class="form-control" id="recipient-name">
                                </div>
                                <div class="form-group">
                                    <label for="message-text" class="col-form-label">Message:</label>
                                    <textarea class="form-control" id="message-text"></textarea>
                                </div>
                                </form>
                            </div>
                            
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Send message</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <script>
            $('#exampleModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // El botón que activó el modal
                var recipient = button.data('whatever'); // Extraer el valor de data-whatever

                var modal = $(this);
                modal.find('.modal-title').text('New message to ' + recipient);
                modal.find('.modal-body input').val(recipient);
            });
        </script>
    </body>
</html>

<!--
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
                                            
                                            -- Botón de Editar --
                                            <a href="{{ route('locales.edit', $local->id) }}" 
                                                class="text-blue-500 hover:text-blue-700" 
                                                style="margin-right: 10px;">
                                                {{ __('Editar') }}
                                            </a>

                                            <br>

                                            -- Botón de Eliminar --
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
                </div>
            </div>
        </div>
    </div>
</x-app-layout> -->