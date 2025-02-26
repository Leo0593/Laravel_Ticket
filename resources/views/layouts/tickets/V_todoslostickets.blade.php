<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layouts.head')

<body>
    @include('layouts.header')

    <div class="main">
        <div class="main_banner_2" data-aos="fade-down" data-aos-duration="1000"
            style="--banner-image: url('../../images/dashboard/tickets.jpg');">
            <h1><strong>Planes para Todos</strong></h1>
            <h2>Combos Generales o VIP, ¡Tú Decides!</h2>
        </div>

        <div class="main_contenedor">
            <div class="container-fluid main_contenedor">
                @if($noTickets)
                    <div class="alert alert-primary" role="alert">
                        <p class="mb-0">{{ __('No hay tickets aún comprados') }}</p>
                    </div>
                @else
                    <!-- Sección de Filtros -->
                    <form method="GET" action="{{ route('tickets.index') }}" class="mb-4">
                        <div class="row">
                            <!-- Filtro por Nombre de Evento -->
                            <div class="col-md-4 mb-2">
                                <input type="text" class="form-control" name="nombre_evento"
                                    value="{{ request('nombre_evento') }}" placeholder="Buscar evento por nombre">
                            </div>

                            <!-- Filtro por Fecha de Inicio -->
                            <div class="col-md-3 mb-2">
                                <input type="date" class="form-control" name="fecha_inicio"
                                    value="{{ request('fecha_inicio') }}">
                            </div>

                            <!-- Filtro por Fecha de Fin -->
                            <div class="col-md-3 mb-2">
                                <input type="date" class="form-control" name="fecha_fin" value="{{ request('fecha_fin') }}">
                            </div>

                            <!-- Filtro por Estado -->
                            <div class="col-md-3 mb-2">
                                <select class="form-control" name="estado">
                                    <option value="">-- Seleccionar Estado --</option>
                                    <option value="ACTIVO" {{ request('estado') == 'ACTIVO' ? 'selected' : '' }}>ACTIVO
                                    </option>
                                    <option value="CANCELADO" {{ request('estado') == 'CANCELADO' ? 'selected' : '' }}>
                                        CANCELADO</option>
                                    <option value="FINALIZADO" {{ request('estado') == 'FINALIZADO' ? 'selected' : '' }}>
                                        FINALIZADO</option>
                                </select>
                            </div>

                            <!-- Botón de búsqueda -->
                            <div class="col-md-2 mb-2">
                                <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                            </div>
                        </div>
                    </form>

                    <div class="row">
                        @foreach($eventos as $evento)
                            <div class="col-lg-6 col-md-12 mb-4">
                                <div class="card shadow-sm">
                                    <div class="card-header bg-primary text-white text-center">
                                        <h5 class="mb-0">{{ $evento->nombre }} ({{ $evento->estado }})</h5>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover m-0">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th class="text-center">{{ __('Usuario') }}</th>
                                                    <th class="text-center">{{ __('Asiento') }}</th>
                                                    <th class="text-center">{{ __('Plan') }}</th>
                                                    <th class="text-center">{{ __('Pagado') }}</th>
                                                    <th class="text-center">{{ __('Fecha Pago') }}</th>
                                                    <th class="text-center">{{ __('QR') }}</th>
                                                    <th class="text-center">{{ __('QR Válido') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($tickets->where('evento_id', $evento->id) as $ticket)
                                                    <tr>
                                                        <td class="text-center">{{ $ticket->user->name }}</td>
                                                        <td class="text-center">{{ optional($ticket->asiento)->numero_asiento }}
                                                        </td>
                                                        <td class="text-center">{{ optional($ticket->plan)->tipo }} -
                                                            {{ optional($ticket->plan)->precio }}</td>
                                                        <td class="text-center">{{ $ticket->pagado ? 'Sí' : 'No' }}</td>
                                                        <td class="text-center">{{ $ticket->fecha_pago }}</td>
                                                        <td class="text-center">
                                                            @if($ticket->qr)
                                                                {{ $ticket->qr }}
                                                            @else
                                                                {{ __('No Disponible') }}
                                                            @endif
                                                        </td>
                                                        <td class="text-center">{{ $ticket->qr_valido ? 'Sí' : 'No' }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

    </div>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>