<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layouts.head')

<body>
    @include('layouts.header')

    @if(Auth::user() && Auth::user()->role === 'ADMIN')
        <div class="main">
            <div class="main_banner_2" data-aos="fade-down" data-aos-duration="1000"
                style="--banner-image: url('../../images/dashboard/dashboard2.jpg');">
                <h1><strong>DASHBOARD</strong></h1>
                <h3><strong>!Hola, {{ Auth::user() ? Auth::user()->name : 'Invitado' }}¡</strong></h3>
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
                    <img class="card-img-top" src="../../images/dashboard/users.jpg" alt="Card image cap"
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
        <div class="main">
            <div class="main_banner_2" data-aos="fade-down" data-aos-duration="1000"
                style="--banner-image: url('../../images/dashboard/dashboard2.jpg');">
                <h1><strong>DASHBOARD</strong></h1>
                <h3><strong>!Hola, Gestor {{ Auth::user() ? Auth::user()->name : 'Invitado' }}¡</strong></h3>
            </div>

            <div class="main_contenedor" data-aos="fade-up" data-aos-duration="1000" style="margin-top: 20px;">
                
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
            </div>
        </div>
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
                            <button type="submit" name="orderBy" value="tickets" class="btn btn-outline-primary {{ request('orderBy') == 'tickets' ? 'active' : '' }}"">
                                Mis Tickets
                            </button>
                            <button type="submit" name="orderBy" value="historial" class="btn btn-outline-primary {{ request('orderBy') == 'historial' ? 'active' : '' }}"">
                                Historial
                            </button>
                        </div>
                    </div>
                </form>
            </div>
                    @if($tickets->isNotEmpty())
                    <div class="main_contenedor" style="padding: 0px 40px; margin-bottom: 20px;">
                        <div class="main_contenedor" data-aos="fade-up" data-aos-duration="1000"
                            style="grid-template-columns: repeat(auto-fill, minmax(45%, 1fr));
                                display: grid; gap: 55px; padding: 30px 50px;
                            ">
                        @foreach($tickets as $ticket)
                            @if ($ticket->evento->visible == 1)
                            <a class="scale"  style="text-decoration: none;">
                                <div
                                    class="evento-card"
                                    data-img="{{ $ticket->evento->Foto ? asset('storage/' . $ticket->evento->Foto) : 'https://placehold.co/600x400' }}"
                                    style="
                                    background-color:rgb(0, 128, 255);
                                    width: 100%;
                                    height: 300px;
                                    background-image:
                                    linear-gradient(to top, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.05) 70%),
                                    linear-gradient(to bottom, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.05) 70%), 
                                    url('{{ $ticket->evento->Foto ? asset('storage/' . $ticket->evento->Foto) : 'https://placehold.co/600x400' }}'); 
                                    background-size: cover;
                                    background-position: center;
                                    background-repeat: no-repeat;
                                    border-radius: 10px;
                                    box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.4);
                                    text-shadow: 2px 2px 3px rgba(0, 0, 0, 0.3);

                                    display: flex;
                                    flex-direction: column;
                                    justify-content: space-between;
                                    padding: 40px !important;
                                    position: relative; ">

                                    <div style="position: absolute; bottom: 20px; left: 20px; color: white; max-width: 100%;">
                                        @php
                                            // Calcular la diferencia entre la fecha de creación del evento y la fecha actual
                                            $isRecent = \Carbon\Carbon::parse($ticket->evento->fecha_evento)->diffInDays(\Carbon\Carbon::now()) <= 7;

                                            $hoy = \Carbon\Carbon::now();
                                            $fechaEvento = \Carbon\Carbon::parse($ticket->evento->fecha_evento);

                                            // Obtener diferencia en años, meses y días
                                            $diferencia = $hoy->diff($fechaEvento);
                                            $anos = $diferencia->y;
                                            $meses = $diferencia->m;
                                            $dias = $diferencia->d;

                                            // Calcular diferencia total en días (aproximado)
                                            $diasTotales = ($anos * 365) + ($meses * 30) + $dias;

                                            // Evento está cerca si faltan entre 0 y 7 días
                                            $isCercaDeEvento = $diasTotales >= 0 && $diasTotales <= 7;
                                        @endphp

                                        @if ($isRecent)
                                            <span class="badge bg-warning" style="text-shadow: none; color: black;">
                                                NEW
                                            </span>
                                        @endif

                                        @if ($isCercaDeEvento)
                                            <span class="badge bg-info" style="text-shadow: none; color: black;">
                                                A Pocos Días
                                            </span>
                                        @endif

                                        <h5 class="titulo" style="font-size: 1.2rem; margin-bottom: 0px; margin-top: 10px;">{{ $ticket->evento->ArtistaGrupo }}</h5>
                                        <h5 class="titulo" style="font-size: 2.5rem">{{ $ticket->evento->nombre }}</h5>
                                    </div>

                                    <div class="evento-status"
                                        style="position: absolute; left: 50%; transform: translate(-50%, -50%); color: white; font-size: 20px;">
                                        <div class="ver-evento-foto-datos"
                                            style="background-color: 
                                                    {{ $ticket->evento->estado == 'ACTIVO' ? 'var(--Add)' : 
                                                        ($ticket->evento->estado == 'FINALIZADO' ? 'white' : 
                                                        'var(--Delete)') }};
                                                    color: {{ $ticket->evento->estado == 'FINALIZADO' ? 'black' : 'white' }};
                                                    top:0; left: 0; position: relative;">
                                            {{ $ticket->evento->estado }}
                                        </div>
                                    </div>

                                    <div class="ver-evento-foto-fecha">
                                        <div style="font-size: 12px; color: var(--Delete)">
                                            <!-- Aquí muestra el mes y el año del evento -->
                                            {{ \Carbon\Carbon::parse($ticket->evento->fecha_evento)->format('M') }}
                                        </div>
                                        <div style="font-size: 25px; color: black;">
                                            <!-- Aquí muestra el día del evento -->
                                            {{ \Carbon\Carbon::parse($ticket->evento->fecha_evento)->format('d') }}
                                        </div> 
                                    </div>

                                    <div class="ver-evento-foto-asiento">
                            
                                        <div style="font-size: 25px; color: var(--color)">
                                            <i class="fas fa-chair"></i>
                                        </div>
                                        <div style="font-size: 15px; color: black;">
                                            {{ $ticket->asiento->id }}
                                        </div> 
                                    </div>
                                    <!--
                                    <div class="card-body">
                                        @if($ticket->evento->Foto)
                                            <img src="{{ asset('storage/' . $ticket->evento->Foto) }}" 
                                            class="card-img-top" alt="Imagen del evento">
                                        @else
                                            <img src="https://placehold.co/600x400" class="card-img-top" alt="Imagen por defecto">
                                        @endif

                                        
                                        <h5 class="card-title">Evento: {{ $ticket->evento->nombre }}</h5>
                                        <p>Imagen: {{ $ticket->evento->Foto }}</p>
                                        <p><strong>Fecha del Evento:</strong>
                                            {{ \Carbon\Carbon::parse($ticket->evento->fecha_evento)->format('d/m/y') }}</p>
                                        <p><strong>Asiento:</strong> {{ $ticket->asiento->id }}</p>
                                        <p><strong>Plan:</strong> {{ $ticket->plan->tipo }}</p>
                                        <p><strong>Pagado:</strong> {{ $ticket->pagado ? 'Sí' : 'No' }}</p>
                                        <p><strong>Fecha de pago:</strong>
                                            {{ $ticket->fecha_pago ? \Carbon\Carbon::parse($ticket->fecha_pago)->format('d/m/y') : 'N/A' }}
                                        </p>
                                        <p><strong>QR Válido:</strong> {{ $ticket->qr_valido ? 'Sí' : 'No' }}</p>
                                        
                                    </div>-->
                                </div>
                            </a>
                                <!--
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
                                </li> -->
                                @endif
                        @endforeach
                        </div>
                    @else
                        <div class="main_contenedor" style="padding: 0px 40px; margin-bottom: 20px;"
                            data-aos="zoom-in" data-aos-duration="1000"
                            >                       
                            <div class="alert alert-primary" role="alert">
                            <p class="mb-0">{{ __('No tienes tickets en este momento.') }}</p>
                        </div>
                    @endif
            </div>
        </div>
    @endif


    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

</body>

</html>