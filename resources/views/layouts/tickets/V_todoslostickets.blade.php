<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('layouts.head')
    
    <body>
        @include('layouts.header')

        <div class="main">
            <div class="main_banner_2" style="--banner-image: url('../../images/dashboard/tickets.jpg');">
                <h1><strong>Planes para Todos</strong></h1>
                <h2>Combos Generales o VIP, ¡Tú Decides!</h2>
            </div>

            <div class="main_contenedor">
                <div class="container-fluid main_contenedor">
                    @if($noTickets)
                        <div class="alert alert-primary" role="alert">
                            <p class="mb-0">{{ __('No hay tickets aun comprados') }}</p>
                        </div>
                    @else
                        <div class="row">
                        @foreach($eventos as $evento)
                            <div class="col-lg-6 col-md-12 mb-4"> <!-- 2 eventos por fila en pantallas grandes -->
                                <div class="card shadow-sm">
                                    <div class="card-header bg-primary text-white text-center">
                                        <h5 class="mb-0">{{ $evento->nombre }}</h5>
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
                                                        <!-- Nombre del Usuario -->
                                                        <td class="text-center">{{ $ticket->user->name }}</td> 
                                                        <!-- Numero_Asiento con ese id -->
                                                        <td class="text-center">{{ optional($ticket->asiento)->numero_asiento }}</td>
                                                        <!-- Tipo de Plan con ese id - precio -->
                                                        <td class="text-center">{{ optional($ticket->plan)->tipo}} - {{ optional($ticket->plan)->precio }}</td>
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
    </body>
</html>
