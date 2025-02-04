<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('layouts.head')
    
    <body>
        @include('layouts.header')

        <div class="main">
            <h1 class="mt-4">Dashboard</h1>

            <div class="main_contenedor">
                <div class="card" style="width: 18rem; box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);">
                    <img class="card-img-top" src="https://placehold.co/600x400" alt="Card image cap" 
                    style="height: 180px; background-color: #f0f0f0; object-fit: cover; width: 100%;">                                
                    <div class="card-body">
                        <h5 class="card-title"><strong>LOCALIDADES</strong></h5>
                        <p class="card-text">
                            Some quick example text to build on the card title and make up the bulk of the card's content.
                        </p>
                        <a  href="{{ route('locales.index') }}" class="btn btn-primary mt-4">Ver</a>
                    </div>
                </div>

                <div class="card" style="width: 18rem; box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);">
                    <img class="card-img-top" src="https://placehold.co/600x400" alt="Card image cap" 
                    style="height: 180px; background-color: #f0f0f0; object-fit: cover; width: 100%;">                                
                    <div class="card-body">
                        <h5 class="card-title"><strong>EVENTOS</strong></h5>
                        <p class="card-text">
                            Some quick example text to build on the card title and make up the bulk of the card's content.
                        </p>
                        <a  href="{{ route('eventos.index') }}" class="btn btn-primary mt-4">Ver</a>
                    </div>
                </div>

                <div class="card" style="width: 18rem; box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);">
                    <img class="card-img-top" src="https://placehold.co/600x400" alt="Card image cap" 
                    style="height: 180px; background-color: #f0f0f0; object-fit: cover; width: 100%;">                                
                    <div class="card-body">
                        <h5 class="card-title"><strong>ASIENTOS</strong></h5>
                        <p class="card-text">
                            Some quick example text to build on the card title and make up the bulk of the card's content.
                        </p>
                        <a  href="{{ route('asientos.index') }}" class="btn btn-primary mt-4">Ver</a>
                    </div>
                </div>

                <div class="card" style="width: 18rem; box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);">
                    <img class="card-img-top" src="https://placehold.co/600x400" alt="Card image cap" 
                    style="height: 180px; background-color: #f0f0f0; object-fit: cover; width: 100%;">                                
                    <div class="card-body">
                        <h5 class="card-title"><strong>PLANES</strong></h5>
                        <p class="card-text">
                            Some quick example text to build on the card title and make up the bulk of the card's content.
                        </p>
                        <a  href="{{ route('planes.index') }}" class="btn btn-primary mt-4">Ver</a>
                    </div>
                </div>
   
                <div class="card" style="width: 18rem; box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);">
                    <img class="card-img-top" src="https://placehold.co/600x400" alt="Card image cap" 
                    style="height: 180px; background-color: #f0f0f0; object-fit: cover; width: 100%;">                                
                    <div class="card-body">
                        <h5 class="card-title"><strong>TICKETS</strong></h5>
                        <p class="card-text">
                            Some quick example text to build on the card title and make up the bulk of the card's content.
                        </p>
                        <a  href="{{ route('tickets.index') }}" class="btn btn-primary mt-4">Ver</a>
                    </div>
                </div>

            </div>
        </div>
    </body>
</html>


<!--
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}

                    <h1 style="margin: 30px 0 0 0; fosnt-size: 1.5em">{{ __("Locales") }} </h1>

                    <div class="mt-4">
                        <a style="color: green" href="{{ route('locales.index') }}">
                            {{ __('Ver') }}
                        </a>
                    </div>

                    <div class="mt-4">
                        <a style="color: #2563eb" href="{{ route('locales.create') }}">
                            {{ __('Agregar') }}
                        </a>
                    </div>

                    
                    <h1 style="margin: 30px 0 0 0; font-size: 1.5em">{{ __("Planes") }} </h1>

                    <div class="mt-4">
                        <a style="color: green" href="{{ route('planes.index') }}">
                            {{ __('Ver') }}
                        </a>
                    </div>

                    <div class="mt-4">
                        <a style="color: #2563eb" href="{{ route('planes.create') }}">
                            {{ __('Agregar') }}
                        </a>
                    </div>


                    <h1 style="margin: 30px 0 0 0; font-size: 1.5em">{{ __("Eventos") }} </h1>

                    <div class="mt-4">
                        <a style="color: green" href="{{ route('eventos.index') }}">
                            {{ __('Ver') }}
                        </a>
                    </div>

                    <div class="mt-4">
                        <a style="color: #2563eb" href="{{ route('eventos.create') }}">
                            {{ __('Agregar') }}
                        </a>
                    </div>


                    <h1 style="margin: 30px 0 0 0; font-size: 1.5em">{{ __("Tickets") }} </h1>

                    <div class="mt-4">
                        <a style="color: green" href="{{ route('tickets.index') }}">
                            {{ __('Ver') }}
                        </a>
                    </div>

                    <div class="mt-4">
                        <a style="color: #2563eb" href="{{ route('tickets.create') }}">
                            {{ __('Agregar') }}
                        </a>
                    </div>


                    <h1 style="margin: 30px 0 0 0; font-size: 1.5em">{{ __("Asientos") }} </h1>

                    <div class="mt-4">
                        <a style="color: green" href="{{ route('asientos.index') }}">
                            {{ __('Ver') }}
                        </a>
                    </div>

                    <div class="mt-4">
                        <a style="color: #2563eb" href="{{ route('asientos.create') }}">
                            {{ __('Agregar') }}
                        </a>
                    </div>

                    
                    <h1 style="margin: 30px 0 0 0; font-size: 1.5em">{{ __("Usuarios") }} </h1>

                    <div class="mt-4">
                        <a style="color: green" href="{{ route('users.index') }}">
                            {{ __('Ver') }}
                        </a>
                    </div>

                    <!--
                                    {!! QrCode::generate('Hola Mundo'); !!}

                                    -- Tamaño del Qr --
                                    {!! QrCode::size(300)->generate('Hola Mundo'); !!}

                                    -- Color del Qr --
                                    {!! QrCode::color(255,0,0)->generate('Hola Mundo'); !!}

                </div>
            </div>
        </div>
    </div>
</x-app-layout>-->