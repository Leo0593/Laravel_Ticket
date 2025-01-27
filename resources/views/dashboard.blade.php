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

                    <h1 style="margin: 30px 0 0 0; font-size: 1.5em">{{ __("Locales") }} </h1>

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
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
