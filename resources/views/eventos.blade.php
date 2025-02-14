<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('layouts.head')
    
    <body>
        @include('layouts.header')

        <div class="main">
            <div class="main_banner_2" 
                style="--banner-image: url('../../images/dashboard/eventos.jpg');
                padding: 80px;
                height: 50%;
                ">
                <h1><strong>¡Compra tu Entrada para el Evento Perfecto!</strong></h1>
                <h2>Elige el Mejor Lugar para Disfrutar del Show</h2>
            </div>

            <div class="main_organizar">
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

            <div class="main_contenedor"
                style="grid-template-columns: repeat(auto-fill, minmax(45%, 1fr));
                        display: grid;
                    ">
                @if($noEventos)
                    <p>{{ __('No hay eventos') }}</p>
                @else
                    @foreach($eventos as $evento)
                        <div
                        class="evento-card"
                        data-img="{{ $evento->Foto ? asset('storage/' . $evento->Foto) : 'https://placehold.co/600x400' }}"
                        style="
                        background-color:rgb(0, 128, 255);
                        width: 100%;
                        height: 300px;
                        background-image:
                        linear-gradient(to bottom, rgba(2, 77, 223, 0.9), rgba(0, 0, 0, 0.05) 40%),
                        linear-gradient(to top, rgba(2, 77, 223, 0.9), rgba(0, 0, 0, 0.05) 40%),
                        url('{{ $evento->Foto ? asset('storage/' . $evento->Foto) : 'https://placehold.co/600x400' }}'); 
                        background-size: cover;
                        background-position: center;
                        background-repeat: no-repeat;
                        border-radius: 10px;
                        box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.4);
                        text-shadow: 3px 3px 5px rgba(0, 0, 0, 0.5);

                        display: flex;
                        flex-direction: column;
                        justify-content: space-between;
                        padding: 40px !important;
                        position: relative;
                        ">
                            <!-- Artista/Grupo en el centro arriba -->
                            <div style="position: absolute; top: 20px; left: 50%; transform: translateX(-50%); color: white;">
                                <h5 class="titulo" style="font-size: 2.5rem">{{ $evento->ArtistaGrupo }}</h5>
                            </div>

                            <!-- Nombre en la esquina inferior izquierda -->
                            <div style="position: absolute; bottom: 20px; left: 20px; color: white; max-width: 45%;">
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

                            <!-- Ver más en la esquina inferior derecha -->
                            <a href="{{ route('evento.show', $evento->id) }}" class="btn-1" style="position: absolute; bottom: 20px; right: 20px; text-decoration: none; color: white;">
                                Ver más
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const cards = document.querySelectorAll(".evento-card");

                cards.forEach(card => {
                    const imgUrl = card.getAttribute("data-img");

                    if (imgUrl) {
                        const img = new Image();
                        img.crossOrigin = "Anonymous"; // Permite cargar imágenes externas sin problemas
                        img.src = imgUrl;

                        img.onload = function () {
                            // Crear el canvas solo cuando sea necesario
                            const canvas = document.createElement("canvas");
                            const ctx = canvas.getContext("2d");

                            // Establecer dimensiones mínimas para obtener un color representativo de la imagen
                            canvas.width = 10;
                            canvas.height = 10;

                            // Dibujar la imagen a escala pequeña para obtener el color central
                            ctx.drawImage(img, 0, 0, 10, 10);

                            const imageData = ctx.getImageData(5, 5, 1, 1).data; // Color del centro
                            let r = imageData[0];
                            let g = imageData[1];
                            let b = imageData[2];

                            // Aumentar la luminosidad (hacerlo más claro)
                            r = Math.min(255, r + 50); // Incrementar el rojo sin superar 255
                            g = Math.min(255, g + 50); // Incrementar el verde sin superar 255
                            b = Math.min(255, b + 50); // Incrementar el azul sin superar 255

                            // Aumentar la saturación (hacerlo más vibrante)
                            const factor = 1.2; // Ajustar la saturación (1.0 = sin cambios, >1 = más vibrante)
                            r = Math.min(255, r * factor);
                            g = Math.min(255, g * factor);
                            b = Math.min(255, b * factor);

                            // Crear un color de sombra dinámica
                            const color = `rgba(${Math.floor(r)}, ${Math.floor(g)}, ${Math.floor(b)}, 0.1)`;
                            const colorshadow = `rgba(${Math.floor(r)}, ${Math.floor(g)}, ${Math.floor(b)}, 0.8)`;
                            // Aplicar la sombra y el fondo con el gradiente dinámico
                            card.style.boxShadow = `3px 5px 15px ${colorshadow}`;
                            card.style.backgroundImage = `
                                linear-gradient(to top, ${colorshadow}, rgba(0, 0, 0, 0.2) 60%),
                                linear-gradient(to bottom, ${color}, rgba(0, 0, 0, 0.1) 40%),
                                url('${imgUrl}')
                            `;
                        };
                    }
                });
            });
        </script>
    </body>
</html>