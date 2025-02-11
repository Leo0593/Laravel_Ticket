<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('layouts.head')
    
    <body>
        @include('layouts.header')

        <div class="main">
            <div class="main_banner_1">
                <h1>TICKETS</h1>
                <button class="btn-1" onclick="window.location.href='{{ route('evento.all') }}'">Ver</button>
                <a href="{{ route('evento.all') }}" class="btn-1">Ver</a>
            </div>

            <div 
                class="p-5 d-flex align-items-center justify-content-center" 
                style="width: 100%; 
                flex-grow: 1; 
                position: relative;">
                <!-- Botón Anterior -->
                <button class="carousel-control-prev custom-carousel-btn" type="button" data-bs-target="#carouselEventos" data-bs-slide="prev"
                    style="width: 5% !important">
                    <span class="carousel-control-prev-icon"></span>
                </button>

                <!-- Carrusel -->
                <div id="carouselEventos" class="carousel slide" data-bs-ride="carousel" 
                    style="width: 90%; height: 100%;">

                    <div class="carousel-inner d-flex" style="height: 100%;">
                        <!-- Loop para crear los slides dinámicamente -->
                        @foreach($eventos->chunk(2) as $eventoChunk)  <!-- Divide los eventos en grupos de 2 para cada slide -->
                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}" style="height: 100%; padding:15px">
                                <div class="d-flex gap-3" style="height: 100%;">
                                    @foreach($eventoChunk as $evento)
                                        <div class="card p-3 flex-fill evento-card" 
                                            data-img="{{ $evento->Foto ? asset('storage/' . $evento->Foto) : 'https://placehold.co/600x400' }}"
                                            style="background-image: 
                                                linear-gradient(to top, rgba(2, 77, 223, 0.9), rgba(0, 0, 0, 0.2) 60%),
                                                url('{{ $evento->Foto ? asset('storage/' . $evento->Foto) : 'https://placehold.co/600x400' }}'); 
                                                width: 100%;
                                                height: 100%; 
                                                background-size: cover; 
                                                background-position: center;
                                                background-repeat: no-repeat;
                                                color: white;
                                                border: none;
                                                border-radius: 10px; 
                                                overflow: hidden;
                                                box-shadow: 3px 5px 10px rgba(0, 0, 0, 0.7);
                                                display: flex;
                                                flex-direction: row;
                                                justify-content: space-between;
                                                align-items: flex-end;
                                                padding: 40px !important;
                                                text-shadow: 2px 2px 3px rgba(0, 0, 0, 0.5);
                                                ">
                                            <div style="color: white; width: auto; display: flex; max-width: 45%;"> 
                                                <h5 style="font-size: 2.5rem;">{{ $evento->nombre }}</h5>
                                            </div>

                                            <a href="{{ route('evento.show', $evento->id) }}" class="btn-1" style="text-decoration: none;">
                                                Ver más
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Botón Siguiente -->
                <button class="carousel-control-next custom-carousel-btn" type="button" data-bs-target="#carouselEventos" data-bs-slide="next"
                    style="width: 5% !important;">
                    <span class="carousel-control-next-icon"></span>
                </button>

            </div>
        </div>

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>

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
                            const canvas = document.createElement("canvas");
                            const ctx = canvas.getContext("2d");

                            canvas.width = 10;
                            canvas.height = 10;
                            ctx.drawImage(img, 0, 0, 10, 10);

                            const imageData = ctx.getImageData(5, 5, 1, 1).data; // Color del centro
                            let r = imageData[0];
                            let g = imageData[1];
                            let b = imageData[2];

                            // 🔹 Aumentar la luminosidad (Hacerlo más claro)
                            r = Math.min(255, r + 50); // Incrementa el rojo sin pasar de 255
                            g = Math.min(255, g + 50); // Incrementa el verde sin pasar de 255
                            b = Math.min(255, b + 50); // Incrementa el azul sin pasar de 255

                            // 🔹 Aumentar la saturación (Hacerlo más vibrante)
                            const factor = 1.2; // Ajusta la saturación (1.0 = sin cambios, >1 = más vibrante)
                            r = Math.min(255, r * factor);
                            g = Math.min(255, g * factor);
                            b = Math.min(255, b * factor);

                            const color = `rgba(${Math.floor(r)}, ${Math.floor(g)}, ${Math.floor(b)}, 0.9)`;

                            // Aplicar sombra y gradiente dinámico
                            card.style.boxShadow = `3px 5px 15px ${color}`;
                            card.style.backgroundImage = `
                                linear-gradient(to top, ${color}, rgba(0, 0, 0, 0.2) 60%),
                                url('${imgUrl}')
                            `;
                        };
                    }
                });
            });
        </script>
    </body>
</html>