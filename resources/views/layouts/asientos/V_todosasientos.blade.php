<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('layouts.head')
    
    <body>
        @include('layouts.header')

        <div class="main">
            <div class="main_banner_2"
            data-aos="fade-down" data-aos-duration="1000" 
            style="--banner-image: url('../../images/dashboard/asientos.png');">
                <h1><strong>Asientos para Cada Ocasión</strong></h1>
                <h2>Disfruta de la Comodidad en Tu Evento</h2>
            </div>

            <div class="main_contenedor">
                <div class="container-fluid main_contenedor mt-4">
                    @if($noAsientos)
                        <div class="alert alert-warning text-center" role="alert">
                            <p class="mb-0">{{ __('No hay asientos disponibles') }}</p>
                        </div>
                    @else
                        <div class="row">
                            @foreach($eventos as $evento)
                                <div class="col-lg-6 col-md-12 mb-4"> <!-- 2 eventos por fila en pantallas grandes -->
                                    <div class="card shadow-sm">
                                        <div class="card-header bg-primary text-white text-center">
                                            <h5 class="mb-0">{{ $evento->nombre }} - {{ $evento->local->Nombre }}</h5>
                                        </div>
                                        <div class="card-body p-0 mb-0">
                                            @if($asientos->where('evento_id', $evento->id)->isEmpty())
                                                <p class="text-center text-muted">No hay asientos para este evento.</p>
                                            @else
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-hover m-0">
                                                        <thead class="table-dark">
                                                            <tr>
                                                                <th class="text-center">{{ __('Plan ID') }}</th>
                                                                <th class="text-center">{{ __('Tipo') }}</th>
                                                                <th class="text-center">{{ __('Número') }}</th>
                                                                <th class="text-center">{{ __('Estado') }}</th>
                                                                <th class="text-center">{{ __('Acciones') }}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($asientos->where('evento_id', $evento->id) as $asiento)
                                                                <tr>
                                                                    <td class="text-center">{{ $asiento->plan_id }}</td>
                                                                    <td class="text-center">{{ $asiento->tipo }}</td>
                                                                    <td class="text-center">{{ $asiento->numero_asiento }}</td>
                                                                    <td class="text-center">
                                                                        <span class="badge {{ $asiento->estado == 'Disponible' ? 'bg-success' : 'bg-danger' }}">
                                                                            {{ $asiento->estado }}
                                                                        </span>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <a href="{{ route('asientos.edit', $asiento->id) }}" 
                                                                            class="btn btn-sm btn-warning"
                                                                            style="color: white;">
                                                                            <i class="fa-solid fa-pen"></i>
                                                                        </a>
                                                                        <form action="{{ route('asientos.destroy', $asiento->id) }}" 
                                                                            method="POST" class="d-inline">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" 
                                                                                class="btn btn-sm btn-danger"
                                                                                onclick="return confirm('¿Estás seguro de eliminar este asiento?')">
                                                                                <i class="fa-solid fa-trash"></i>
                                                                            </button>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @endif
                                        </div>
                                        <!--
                                        <div class="card-footer text-muted text-center mt-0">
                                            <small>{{ __('Última actualización: ') . now()->format('d/m/Y H:i') }}</small>
                                        </div> -->
                                    </div>  
                                </div>
                            @endforeach
                        </div>
                    @endif

                <!--
                @if($noAsientos)
                    <p>{{ __('No hay asientos') }}</p>
                @else
                    @foreach($eventos as $evento)
                        <div class="table_cont"> 
                            <div class="card text-center">
                                    <div class="card-header">
                                        {{ $evento->id }}. {{ $evento->nombre }} - {{ $evento->local_id }}
                                    </div>
                                    <div class="card-body">
                                        <table class="min-w-full bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                                            <thead>
                                                <tr>
                                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600">{{ __('Local_id') }}</th>
                                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600">{{ __('Plan_id') }}</th>
                                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600">{{ __('Tipo') }}</th>
                                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600">{{ __('Número Asiento') }}</th>
                                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600">{{ __('Estado') }}</th>
                                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600">{{ __('Acciones') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($asientos->where('evento_id', $evento->id) as $asiento)
                                                    <tr>
                                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">{{ $asiento->local_id }}</td>
                                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">{{ $asiento->plan_id }}</td>
                                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">{{ $asiento->tipo }}</td>
                                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">{{ $asiento->numero_asiento }}</td>
                                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">{{ $asiento->estado }}</td>
                                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                                                            <a href="{{ route('asientos.edit', $asiento->id) }}" class="text-blue-500 hover:text-blue-700">
                                                                {{ __('Editar') }}
                                                            </a>
                                                            <br>
                                                            <form action="{{ route('asientos.destroy', $asiento->id) }}" method="POST" class="inline-block">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="text-red-500 hover:text-red-700 ml-4" 
                                                                    onclick="return confirm('¿Estás seguro de que deseas eliminar este asiento?')">
                                                                    {{ __('Eliminar') }}
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="card-footer text-muted">
                                    </div>
                            </div>    
                        </div>    
                    @endforeach
                @endif
-->
            </div>
                    <!--
                        <table class="min-w-full bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600" scope="col">{{ __('Local') }}</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600" scope="col">{{ __('Evento') }}</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600" scope="col">{{ __('Plan') }}</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600" scope="col">{{ __('Tipo') }}</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600" scope="col">{{ __('Número Asiento') }}</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600" scope="col">{{ __('Estado') }}</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600" scope="col">{{ __('Acciones') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($asientos as $asiento)
                                    <tr>
                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">{{ $asiento->local_id }}</td>
                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">{{ $asiento->evento_id }}</td>
                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">{{ $asiento->plan_id }}</td>
                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">{{ $asiento->tipo }}</td>
                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">{{ $asiento->numero_asiento }}</td>
                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">{{ $asiento->estado }}</td>

                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">

                                            <a href="{{ route('asientos.edit', $asiento->id) }}" 
                                                class="text-blue-500 hover:text-blue-700" 
                                                style="margin-right: 10px;">
                                                {{ __('Editar') }}
                                            </a>

                                            <br>

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
                    -->

        </div>

        <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
        <script>
            AOS.init();
        </script>
    </body>
</html>