<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('layouts.head')
    
    <body>
        @include('layouts.header')

        <div class="main">
            <div class="main_banner_2" 
                data-aos="fade-down" data-aos-duration="1000"
                style="--banner-image: url('../../images/dashboard/eventos.jpg');
                padding: 80px;
                height: 50%;
                ">
                <h1><strong>¡Compra tu Entrada para el Evento Perfecto!</strong></h1>
                <h2>Elige el Mejor Lugar para Disfrutar del Show</h2>
            </div>

            <div class="main_organizar" data-aos="zoom-in" data-aos-duration="1000">
                <form method="GET" action="">
                    <h4>Ordenar por:</h4>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group">
                            <button type="submit" name="orderBy" value="recientes" class="btn btn-outline-primary {{ request('orderBy') == 'recientes' ? 'active' : '' }}">
                                Eventos Recientes
                            </button>
                            <button type="submit" name="orderBy" value="cerca_de_comenzar" class="btn btn-outline-primary {{ request('orderBy') == 'cerca_de_comenzar' ? 'active' : '' }}">
                                Eventos Cercanos
                            </button>
                            <button type="submit" name="orderBy" value="artista_grupo" class="btn btn-outline-primary {{ request('orderBy') == 'artista_grupo' ? 'active' : '' }}">
                                Artista/Grupo
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="main_contenedor" data-aos="fade-up" data-aos-duration="1000"
                style="grid-template-columns: repeat(auto-fill, minmax(45%, 1fr));
                        display: grid; gap: 55px; padding: 30px 50px;
                    ">
                @if($noEventos)
                    <p>{{ __('No hay eventos') }}</p>
                @else
                    @foreach($eventos as $evento)
                        <a class="scale" href="{{ route('evento.show', $evento->id) }}" style="text-decoration: none;">

                            @php
                                $fecha = \Carbon\Carbon::parse($evento->fecha_evento);
                            @endphp

                            <div
                                class="evento-card"
                                data-img="{{ $evento->Foto ? asset('storage/' . $evento->Foto) : 'https://placehold.co/600x400' }}"
                                style="
                                background-color:rgb(0, 128, 255);
                                width: 100%;
                                height: 300px;
                                background-image:
                                linear-gradient(to top, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.05) 70%),
                                linear-gradient(to bottom, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.05) 70%), 
                                url('{{ $evento->Foto ? asset('storage/' . $evento->Foto) : 'https://placehold.co/600x400' }}'); 
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
                                position: relative;
                                ">
                                
                                <!-- Artista/Grupo en el centro arriba -->
                                <div style="position: absolute; color: white;">
                                    <h5 class="titulo" style="font-size: 2.5rem">{{ $evento->ArtistaGrupo }}</h5>
                                </div>

                                <!-- Nombre en la esquina inferior izquierda -->
                                <div style="position: absolute; bottom: 20px; left: 20px; color: white; max-width: 100%;">
                                    @php
                                        // Calcular la diferencia entre la fecha de creación del evento y la fecha actual
                                        $isRecent = \Carbon\Carbon::parse($evento->created_at)->diffInDays(\Carbon\Carbon::now()) <= 7;

                                        $hoy = \Carbon\Carbon::now();
                                        $fechaEvento = \Carbon\Carbon::parse($evento->fecha_evento);

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

                                    <h5 style="font-fmaily: 'Work Sans', sans-serif; font-weight: 400; font-size: 2rem;">{{ $evento->nombre }}</h5>
                                </div>

                                <div class="ver-evento-foto-fecha" >
                                    <div style="font-size: 12px; color: var(--Delete)">{{ $fecha->format('M') }}</div>
                                    <div style="font-size: 25px; color: black;">{{ $fecha->day }}</div> 
                                </div>   
                                <!-- Ver más en la esquina inferior derecha 
                                <a href="{{ route('evento.show', $evento->id) }}" class="btn-1" style="position: absolute; bottom: 20px; right: 20px; text-decoration: none; color: white;">
                                    Ver más
                                </a>-->
                            </div>
                        </a>
                    @endforeach
                @endif
            </div>
        </div>

        <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
        <script>
            AOS.init();
        </script>
    </body>
</html>