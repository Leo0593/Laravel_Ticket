<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layouts.head')

<body>
    @include('layouts.header')



    @if(Auth::user() && Auth::user()->role === 'ADMIN')
        <div class="main">
            <div class="main_banner_2" data-aos="fade-down" data-aos-duration="1000" data-aos-delay="250"
                style="--banner-image: url('../../images/dashboard/dash.jpg');">
                <h1><strong>DASHBOARD</strong></h1>
            </div>

            <div class="main_contenedor" data-aos="fade-up" data-aos-duration="1000" style="margin-top: 20px;">
                <div class="scale card" style="width: 18rem; box-shadow: 0 0 10px var(--color);">
                    <img class="card-img-top" src="../../images/dashboard/estadio-1.webp" alt="Card image cap"
                        style="height: 180px; background-color: #f0f0f0; object-fit: cover; width: 100%;">
                    <div class="card-body">
                        <h5 class="card-title"><strong>LOCALIDADES</strong></h5>
                        <p class="card-text">
                            Aquí podrás gestionar las diferentes zonas de acceso al evento. Añadir o editar localidades,
                            establecer precios y asignar características a cada zona. Asegúrate de ofrecer opciones para
                            todo tipo de público.
                        </p>

                        <div style="display:flex; justify-content: center;">
                            <a href="{{ route('locales.index') }}" class="btn btn-primary mt-4">
                                <i class="fa-solid fa-eye" style="margin-right: 5px"></i>
                                Ver más
                            </a>
                        </div>
                    </div>
                </div>

                <div class="scale card" style="width: 18rem; box-shadow: 0 0 10px var(--color);">
                    <img class="card-img-top" src="../../images/dashboard/eventos.jpg" alt="Card image cap"
                        style="height: 180px; background-color: #f0f0f0; object-fit: cover; width: 100%;">
                    <div class="card-body">
                        <h5 class="card-title"><strong>EVENTOS</strong></h5>
                        <p class="card-text">
                            Crea y organiza tus eventos aquí. Define fechas, horarios, lugares y los detalles importantes
                            que harán que el evento sea inolvidable. Gestiona la información fácilmente.
                        </p>

                        <div style="display:flex; justify-content: center;">
                            <a href="{{ route('eventos.index') }}" class="btn btn-primary mt-4">
                                <i class="fa-solid fa-eye" style="margin-right: 5px"></i>
                                Ver más
                            </a>
                        </div>
                    </div>
                </div>

                <div class="scale card" style="width: 18rem; box-shadow: 0 0 10px var(--color);">
                    <img class="card-img-top" src="../../images/dashboard/asientos.png" alt="Card image cap"
                        style="height: 180px; background-color: #f0f0f0; object-fit: cover; width: 100%;">
                    <div class="card-body">
                        <h5 class="card-title"><strong>ASIENTOS</strong></h5>
                        <p class="card-text">
                            Organiza y asigna los asientos para el evento. Puedes configurar la disposición del lugar,
                            permitir la selección de asientos para los asistentes y controlar la disponibilidad.
                        </p>
                        <div style="display:flex; justify-content: center;">
                            <a href="{{ route('asientos.index') }}" class="btn btn-primary mt-4">
                                <i class="fa-solid fa-eye" style="margin-right: 5px"></i>
                                Ver más
                            </a>
                        </div>
                    </div>
                </div>

                <div class="scale card" style="width: 18rem; box-shadow: 0 0 10px var(--color);">
                    <img class="card-img-top" src="../../images/dashboard/plans.png" alt="Card image cap"
                        style="height: 180px; background-color: #f0f0f0; object-fit: cover; width: 100%;">
                    <div class="card-body">
                        <h5 class="card-title"><strong>PLANS & COMBOS</strong></h5>
                        <p class="card-text">
                            Crea planes y combos exclusivos para tus eventos, ofreciendo diferentes opciones de entradas y
                            servicios adicionales. Permite que tus clientes elijan el paquete que mejor se adapte a sus
                            necesidades.
                        </p>

                        <div style="display:flex; justify-content: center;">
                            <a href="{{ route('planes.index') }}" class="btn btn-primary mt-4">
                                <i class="fa-solid fa-eye" style="margin-right: 5px"></i>
                                Ver más
                            </a>
                        </div>
                    </div>
                </div>

                <div class="scale card" style="width: 18rem; box-shadow: 0 0 10px var(--color);">
                    <img class="card-img-top" src="../../images/dashboard/tickets.jpg" alt="Card image cap"
                        style="height: 180px; background-color: #f0f0f0; object-fit: cover; width: 100%;">
                    <div class="card-body">
                        <h5 class="card-title"><strong>TICKETS</strong></h5>
                        <p class="card-text">
                            Gestiona la venta de boletos de tus eventos. Establece precios, cantidades disponibles y
                            controla el flujo de entradas de manera eficiente para asegurar una experiencia sin problemas
                            para los asistentes.
                        </p>
                        <div style="display:flex; justify-content: center;">
                            <a href="{{ route('tickets.index') }}" class="btn btn-primary mt-4">
                                <i class="fa-solid fa-eye" style="margin-right: 5px"></i>
                                Ver más
                            </a>
                        </div>
                    </div>
                </div>

                <div class="scale card" style="width: 18rem; box-shadow: 0 0 10px var(--color);">
                    <img class="card-img-top" src="../../images/dashboard/tickets.jpg" alt="Card image cap"
                        style="height: 180px; background-color: #f0f0f0; object-fit: cover; width: 100%;">
                    <div class="card-body">
                        <h5 class="card-title"><strong>USUARIOS</strong></h5>
                        <p class="card-text">
                            Gestiona la venta de boletos de tus eventos. Establece precios, cantidades disponibles y
                            controla el flujo de entradas de manera eficiente para asegurar una experiencia sin problemas
                            para los asistentes.
                        </p>
                        <div style="display:flex; justify-content: center;">
                            <a href="{{ route('users.index') }}" class="btn btn-primary mt-4">
                                <i class="fa-solid fa-eye" style="margin-right: 5px"></i>
                                Ver más
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @elseif(Auth::user() && Auth::user()->role === 'GESTOR')
        <p>Bienvenido, Gestor.</p>
    @else
        <div class="main">
            <div class="main_banner_2" data-aos="fade-down" data-aos-duration="1000"
                style="--banner-image: url('../../images/dashboard/albums.png');">
                <h1><strong>!Bienvenido/a, {{ Auth::user() ? Auth::user()->name : 'Invitado' }}¡</strong></h1>
            </div>

            <div class="main_organizar" data-aos="zoom-in" data-aos-duration="1000">
                <form method="GET" action="">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group">
                            <button type="submit" name="orderBy" value="nombre" class="btn btn-outline-primary">
                                Mis Tickets
                            </button>
                            <button type="submit" name="orderBy" value="aforo" class="btn btn-outline-primary ">
                                Historial
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- ACA LEANDRO -->
            <div class="main_contenedor">
                @if($tickets->isNotEmpty())
                    <ul>
                        @foreach($tickets as $ticket)
                            <li>
                                <div class="card-body">
                                    <h5 class="card-title">Evento: {{ $ticket->evento->nombre }}</h5>
                                    <p><strong>Fecha del Evento:</strong>
                                        {{ \Carbon\Carbon::parse($ticket->evento->fecha_evento)->format('d/m/y') }}</p>
                                    <p><strong>Asiento:</strong> {{ $ticket->asiento->id }}</p>
                                    <p><strong>Plan:</strong> {{ $ticket->plan->tipo }}</p>
                                    <p><strong>Pagado:</strong> {{ $ticket->pagado ? 'Sí' : 'No' }}</p>
                                    <p><strong>Fecha de pago:</strong>
                                        {{ $ticket->fecha_pago ? \Carbon\Carbon::parse($ticket->fecha_pago)->format('d/m/y') : 'N/A' }}
                                    </p>
                                    <p><strong>QR Válido:</strong> {{ $ticket->qr_valido ? 'Sí' : 'No' }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>No tienes tickets en este momento.</p>
                @endif
            </div>
        </div>
    @endif


    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>