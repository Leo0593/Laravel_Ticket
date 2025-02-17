<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('layouts.head')
    
    <body>
        @include('layouts.header')

        <div class="main">
            <div class="main_banner_1" data-aos="fade-down" data-aos-duration="1000">
                <h1 data-aos="zoom-in" data-aos-duration="1200" style="font-size: 80px">TICKETS</h1>
                <button 
                data-aos="zoom-in" data-aos-duration="1500"
                class="btn-1" onclick="window.location.href='{{ route('evento.all') }}'"
                >
                Ver
                </button>
            </div>

            <div 
                class="p-5 d-flex align-items-center justify-content-center" 
                style="width: 100%; padding: 0px !important; 
                flex-grow: 1; 
                position: relative;"
                data-aos="fade-up" data-aos-duration="1000">
                <!-- Botón Anterior -->
                <button class="carousel-control-prev custom-carousel-btn" type="button" data-bs-target="#carouselEventos" data-bs-slide="prev"
                    style="width: 5% !important">
                    <span class="carousel-control-prev-icon scale"></span>
                </button>

                <!-- Carrusel -->
                <div id="carouselEventos" class="carousel slide" data-bs-ride="carousel" 
                    style="width: 90%; height: 100%;">

                    <div class="carousel-inner d-flex" style="height: 100%; padding: 38px;">
                        <!-- Loop para crear los slides dinámicamente -->
                        @foreach($eventos->chunk(2) as $eventoChunk)  
                            <!-- Divide los eventos en grupos de 2 para cada slide -->
                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}" style="height: 100%; padding:15px">
                                <div class="d-flex gap-3" style="height: 100%; gap: 50px !important;">
                                    @foreach($eventoChunk as $evento)
                                        <a href="{{ route('evento.show', $evento->id) }}" style="text-decoration: none; width: 100%;">
                                        <div class="card p-3 flex-fill evento-card scale" 
                                            data-img="{{ $evento->Foto ? asset('storage/' . $evento->Foto) : 'https://placehold.co/600x400' }}"
                                            style="background-image: 
                                                linear-gradient(to top, rgba(0, 0, 0, 0.9), rgba(0, 0, 0, 0.2) 80%),
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
                                                box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.6);
                                                display: flex;
                                                flex-direction: row;
                                                justify-content: space-between;
                                                align-items: flex-end;
                                                padding: 40px !important;
                                                text-shadow: 2px 2px 3px rgba(0, 0, 0, 1);
                                                ">
                                            <div style="color: white; width: auto; display: flex; max-width: 100%;"> 
                                                <h5 style="font-size: 2.5rem; font-family: 'Montserrat', sans-serif; font-weight: 400;">{{ $evento->nombre }}</h5>
                                            </div>
                                        </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Botón Siguiente -->
                <button class="carousel-control-next custom-carousel-btn" type="button" data-bs-target="#carouselEventos" data-bs-slide="next"
                    style="width: 5% !important;">
                    <span class="carousel-control-next-icon scale"></span>
                </button>

            </div>
        </div>

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>

        <!-- Color gradient and shadow effect -->
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const cards = document.querySelectorAll(".evento-card");

                cards.forEach(card => {
                    const imgUrl = card.getAttribute("data-img");

                    if (imgUrl) {
                        const img = new Image();
                        img.crossOrigin = "Anonymous"; // Evita problemas con imágenes externas
                        img.src = imgUrl;

                        img.onload = function () {
                            const canvas = document.createElement("canvas");
                            const ctx = canvas.getContext("2d");

                            canvas.width = 10;
                            canvas.height = 10;
                            ctx.drawImage(img, 0, 0, 10, 10);

                            // 🔹 Obtener colores en distintas posiciones
                            function getColorAt(x, y) {
                                const imageData = ctx.getImageData(x, y, 1, 1).data;
                                return { r: imageData[0], g: imageData[1], b: imageData[2] };
                            }

                            let primary = getColorAt(5, 5); // Centro
                            let secondary = getColorAt(1, 1); // Esquina superior izquierda
                            let tertiary = getColorAt(9, 9); // Esquina inferior derecha

                            // 🔹 Función para calcular la "luminosidad" de un color (cuánto brillo tiene)
                            function getBrightness(color) {
                                return (color.r * 0.299 + color.g * 0.587 + color.b * 0.114);
                            }
                            
                            // 🔹 Verifica si un color es "casi blanco" o "casi negro"
                            function isNearWhiteOrBlack(color) {
                                let brightness = getBrightness(color);
                                return brightness < 30 || brightness > 220; // Casi negro (<30) o casi blanco (>220)
                            }

                            // 🔹 Filtrar los colores más útiles
                            let validColors = [primary, secondary, tertiary].filter(color => !isNearWhiteOrBlack(color));

                            // Si todos son blancos/negros, usamos el color más cercano al medio
                            let bestColor;
                            if (validColors.length > 0) {
                                // Ordenar colores por luminosidad (más oscuro a más claro)
                                validColors.sort((a, b) => getBrightness(a) - getBrightness(b));
                                
                                // Buscar el color más cercano al medio
                                const midBrightness = 128; // Brillo medio (rango de 0-255)
                                bestColor = validColors.reduce((prev, curr) => {
                                    return Math.abs(getBrightness(curr) - midBrightness) < Math.abs(getBrightness(prev) - midBrightness) ? curr : prev;
                                });
                            } else {
                                // Si no hay colores válidos, usar el más cercano al medio de los tres colores
                                const allColors = [primary, secondary, tertiary];
                                bestColor = allColors.reduce((prev, curr) => {
                                    return Math.abs(getBrightness(curr) - midBrightness) < Math.abs(getBrightness(prev) - midBrightness) ? curr : prev;
                                });
                            }

                            function darkenColor(color, amount) {
                                let r = Math.max(0, color.r - amount); // Reduce el rojo
                                let g = Math.max(0, color.g - amount); // Reduce el verde
                                let b = Math.max(0, color.b - amount); // Reduce el azul
                                return `rgba(${Math.floor(r)}, ${Math.floor(g)}, ${Math.floor(b)}, 1)`;
                            }

                            function lightenColor(color, amount) {
                                let r = Math.min(255, color.r * amount); // Aumenta el rojo
                                let g = Math.min(255, color.g * amount); // Aumenta el verde
                                let b = Math.min(255, color.b * amount); // Aumenta el azul
                                // Limitar la claridad del color para evitar que se haga demasiado blanco
                                const maxBrightness = 20;  // Brillo máximo que se permite
                                const currentBrightness = getBrightness({ r, g, b });
                                if (currentBrightness > maxBrightness) {
                                    r = Math.max(0, r - (currentBrightness - maxBrightness)); // Evitar sobrepasar el brillo máximo
                                    g = Math.max(0, g - (currentBrightness - maxBrightness)); // Evitar sobrepasar el brillo máximo
                                    b = Math.max(0, b - (currentBrightness - maxBrightness)); // Evitar sobrepasar el brillo máximo
                                }
                                return `rgba(${Math.floor(r)}, ${Math.floor(g)}, ${Math.floor(b)}, 1)`;
                            }

                            // Ajustamos el color dependiendo de su luminosidad
                            let finalColor;
                            const brightness = getBrightness(bestColor);
                            if (brightness < 128) {
                                finalColor = lightenColor(bestColor, 1);  // Aclarar si es oscuro
                            } else {
                                finalColor = darkenColor(bestColor, 50);   // Oscurecer si es claro
                            }

                            function increaseGreenAndBlue(color, factor) {
                                let r = color.r;
                                let g = Math.min(255, color.g * factor); // Aumentamos el verde
                                let b = Math.min(255, color.b * factor); // Aumentamos el azul
                                return `rgba(${r}, ${g}, ${b}, 1)`;
                            }

                            let finalShadowColor = increaseGreenAndBlue(bestColor, 1); // Aumenta un 50% el verde y azul

                            card.style.boxShadow = `5px 5px 10px ${finalShadowColor.replace(/rgba\((\d+), (\d+), (\d+), 1\)/, (match, r, g, b) => `rgba(${r}, ${g}, ${b}, 1.5)`)}`;

                            // 🔹 Aplicar el color más adecuado
                            card.style.backgroundImage = `
                                linear-gradient(to top, ${finalColor}, rgba(0, 0, 0, 0.2) 80%),
                                url('${imgUrl}')
                            `;
                        };
                    }
                });
            });
        </script>

        <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
        <script>
            AOS.init();
        </script>

    </body>
</html>