<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('layouts.head')
    
    <body style="background-color: rgb(240, 240, 240);">
        @include('layouts.header')

        <div class="main">
            <div
                id="banner" 
                class="main_banner_2 evento-card" 
                style="
                    background-image: 
                    linear-gradient(to top, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.05) 70%),
                    linear-gradient(to bottom, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.05) 70%), 
                    url('{{ $evento->Foto ? asset('storage/' . $evento->Foto) : 'https://placehold.co/600x400' }}');                
                    background-size: cover;
                    background-position: center 25%;
                    height: 400px;
                    display: flex;
                    align-items: flex-start;
                    justify-content: space-between;
                    text-shadow: 3px 3px 5px rgba(0, 0, 0, 0.5);
                    padding: 40px 100px;
                    " data-aos="fade-down" data-aos-duration="1000">
                    <h1 class="titulo" style="font-size: 4.5rem;">
                    {{ $evento->ArtistaGrupo }}</h1>
                    <h1 class="sub-titulo" style="font-size: 3.5rem;">{{ $evento->nombre }}</h1>
                    <input type="hidden" id="eventoFotoUrl" value="{{ $evento->Foto ? asset('storage/' . $evento->Foto) : 'https://placehold.co/600x400' }}">
            </div>

            <div style="
                width: 100%;
                display: flex;
                flex-direction: column;
                align-items: center;
                flex-grow: 1;
                ">

                <div style=" 
                    width: 100%;
                    display: flex;
                    justify-content: center; 
                    padding: 10px;
                    background-color: white;
                    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.4);

                    position: sticky;
                    top: 0;
                    z-index: 1000;
                    "
                    data-aos="fade-down" data-aos-duration="1000" data-aos-once="true"
                    >
                    <nav class="nav">
                        <a class="nav-link" href="#banner">BANNER</a>
                        <a class="nav-link" href="#fecha">FECHA</a>
                        <a class="nav-link" href="#info">INFO</a>
                        <a class="nav-link" href="#entradas">ENTRADAS</a>
                    </nav>
                </div>

                <div
                    id="fecha" 
                    class="m-5"
                    data-aos="zoom-in" data-aos-duration="1200"
                    style="
                    width: 70%;
                    background-color: white;
                    padding: 20px 50px;
                    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.4);

                    scroll-margin-top: 110px;
                    ">

                    <div class="eventos-title-container">
                        <h2 class="eventos-title">FECHA</h2>
                    </div>
                    
                    @php
                        $fecha = \Carbon\Carbon::parse($evento->fecha_evento);
                    @endphp

                    <div class="evento-info" style="display: flex; align-items: center; padding: 20px;
                        ">
                        <!-- Contenedor para la fecha y hora -->
                        <div style="background-color: ; display: flex; flex-direction: column; align-items: center; margin-right: 40px;">
                            <div style="font-size: 20px;">{{ $fecha->format('M') }}</div>  <!-- Mes abreviado -->
                            <div style="font-size: 26px;">{{ $fecha->day }}</div>  <!-- Día -->
                        </div>
                        
                        <!-- Contenedor para el nombre del evento y lugar -->
                        <div>
                            <div style="font-size: 14px; color: gray;">{{ $fecha->locale('es')->dayName }}, {{ $fecha->format('H:i') }} h</div>  <!-- Día de la semana y hora -->
                            <div style="font-size: 20px; font-weight: bold;">{{ optional($evento->local)->Nombre }}</div>
                            <div style="font-size: 16px; color: gray;">{{ $evento->ArtistaGrupo }}</div>
                        </div>

                        <!-- Botón de "Entradas" -->
                        <div style="margin-left: auto;">
                            <a href="#entradas" class="btn-1" style="border: 2px solid #000; color: #000; padding: 10px 20px; text-decoration: none; display: inline-flex; align-items: center;">
                                <i class="fa-solid fa-cart-plus" style="margin-right: 8px"></i>
                                Entradas
                            </a>
                        </div>

                    </div>
                </div>

                <div 
                    id="info"
                    data-aos="zoom-in" data-aos-duration="1200"
                    class="m-5"
                    style="
                    width: 70%;
                    background-color: white;
                    padding: 20px 50px;
                    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.4);

                    scroll-margin-top: 110px;
                    ">

                    <div class="eventos-title-container">
                        <h2 class="eventos-title">INFO</h2>
                    </div>

                    <p><?= htmlspecialchars_decode($evento->descripcion) ?></p>
                </div>

                <div 
                    id="entradas"
                    class="m-5"
                    data-aos="zoom-in" data-aos-duration="1200"
                    style="
                    width: 70%;
                    background-color: white;
                    padding: 20px 50px;
                    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.4);
                    scroll-margin-top: 110px;
                    ">

                    <div class="eventos-title-container">
                        <h2 class="eventos-title">ENTRADAS</h2>
                    </div>

                    <div style="display: flex; flex-wrap: wrap; justify-content: space-around;"> 
                        @foreach($evento->planes as $index => $plan)   
                            
                            <div class="contenedor-plan-info scale">
                                <div class="plan-img" 
                                    data-img="{{ $plan->Foto ? asset('storage/' . $plan->Foto) : 'https://placehold.co/600x400' }}"
                                    style="background-image: linear-gradient(to top, rgba(0, 0, 0, 0.9), rgba(0, 0, 0, 0.8) 80%), 
                                    url('{{ $plan->Foto ? asset('storage/' . $plan->Foto) : 'https://placehold.co/600x400' }}');
                                    background-size: cover;
                                    background-position: center;
                                    background-repeat: no-repeat;">
                                    <img id="hiddenImage-{{ $index }}" 
                                        src="{{ $plan->Foto ? asset('storage/' . $plan->Foto) : 'https://placehold.co/600x400' }}" 
                                        style="display: none;">
                                </div>
                                <div class="plan-info">
                                    <h4 id="headerText-{{ $index }}" style="margin: 0;">{{ $plan->tipo }}</h4>
                                    <h2 style="margin: 10px; font-weight: bold">{{ $plan->precio }} €</h2>
                                    <p><?= htmlspecialchars_decode($plan->descripcion) ?></p>
                                    <div style="display: flex; justify-content: center; margin: 20px;">
                                        <a href="{{ route('payment.index', ['planId' => $plan->id]) }}" class="btn-1" style="border: 2px solid #000; color: #000; padding: 10px 20px; text-decoration: none; display: inline-flex; align-items: center;">
                                            <i class="fa-solid fa-ticket" style="margin-right: 8px"></i>
                                            Comprar
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!--
                            <div 
                                style="
                                display: flex;
                                flex-wrap: wrap;
                                border: 1px solid rgba(0, 0, 0, 0.175);
                                border-radius: 10px;
                                overflow: hidden;
                                height: auto;
                                margin-bottom: 40px;
                                box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.2);
                                ">

                                 Información 
                                <div 
                                    style="flex: 1 1 50%;
                                    display: flex;
                                    flex-direction: column;
                                    justify-content: space-between;
                                    ">

                                     Header 
                                    <div 
                                        id="header-{{ $index }}"
                                        class="header"
                                        style="background-color: rgb(246, 246, 246);
                                        width: 100%;
                                        height: auto;
                                        padding: 10px;
                                        border-bottom: 1px solid rgba(0, 0, 0, 0.17);
                                        text-align: center;
                                        font-weight: bold;
                                        font-size: 25px;
                                        display: flex;
                                        align-text: center;
                                        justify-content: center;
                                        "> 
                                        <h4 id="headerText-{{ $index }}" style="margin: 0;">{{ $plan->tipo }}</h4>
                                    </div>

                                    Descripcion
                                    <div 
                                        style="
                                        width: 100%;
                                        height: auto;
                                        padding: 10px 30px;
                                        text-align: center;
                                        flex-grow: 1;
                                        ">
                                        <h2 style="margin: 10px; font-weight: bold">{{ $plan->precio }} €</h2>
                                            <p><?= htmlspecialchars_decode($plan->descripcion) ?></p>

                                            <div style="display: flex; justify-content: center; margin: 20px;">
                                                <a href="{{ route('payment.index', ['planId' => $plan->id]) }}" class="btn-1" style="border: 2px solid #000; color: #000; padding: 10px 20px; text-decoration: none; display: inline-flex; align-items: center;">
                                                    <i class="fa-solid fa-ticket" style="margin-right: 8px"></i>
                                                    Comprar
                                                </a>
                                            </div>

                                    </div>
                                </div>

                                Imagen
                                <div 
                                    style="
                                    flex: 1 1 50%;

                                    background-image: url('{{ $plan->Foto ? asset('storage/' . $plan->Foto) : 'https://placehold.co/600x400' }}');
                                    background-size: cover;
                                    background-position: center;
                                    background-repeat: no-repeat;
                                    ">
                                    <img id="hiddenImage-{{ $index }}" 
                                    src="{{ $plan->Foto ? asset('storage/' . $plan->Foto) : 'https://placehold.co/600x400' }}" 
                                    style="display: none;">
                                </div>
                            </div> -->
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Imagen a la cara
        <script defer src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>

        <script type="module">
            import * as faceapi from 'https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js';

            // Añadir async aquí para que await sea válido
            document.addEventListener('DOMContentLoaded', async function () {
                const banner = document.getElementById('banner');
                const imgUrl = document.getElementById('eventoFotoUrl').value;  // Obtener la URL desde el campo hidden
                console.log(imgUrl);

                // Verificar si faceapi está definido
                if (typeof faceapi === 'undefined') {
                    console.error('faceapi no está definido');
                    return;
                }

                // Cargar el modelo antes de trabajar con la imagen
                try {
                    await faceapi.nets.ssdMobilenetv1.loadFromUri('/storage/models');
                    console.log('Modelo cargado');
                } catch (error) {
                    console.error('Error al cargar el modelo:', error);
                    return;
                }

                // Cargar la imagen y esperar a que esté lista
                const image = new Image();
                image.src = imgUrl;
                image.onload = async function () {
                    console.log('Imagen cargada');

                    // Detectar las caras una vez que la imagen esté lista
                    const detections = await faceapi.detectAllFaces(image);
                    console.log('Detección de caras:', detections);

                    if (detections.length > 0) {
                        const face = detections[0]; // Considera la primera cara detectada
                        const facePosition = face.alignedRect.box;

                        // Ajusta la posición del background según la cara
                        banner.style.backgroundPosition = `${(facePosition.x + facePosition.width / 2) / image.width * 100}% ${((facePosition.y + facePosition.height / 2) / image.height) * 100}%`;
                    }
                };
            });
        </script>
        -->

        <!-- Banner gradient -->
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const eventoBanner = document.getElementById("banner");

                // Obtener la URL de la foto del evento
                const imgUrl = document.getElementById("eventoFotoUrl").value;

                // Cargar la imagen
                const img = new Image();
                img.crossOrigin = "Anonymous"; // Evitar problemas con imágenes externas
                img.src = imgUrl;

                img.onload = function () {
                    const canvas = document.createElement("canvas");
                    const ctx = canvas.getContext("2d");

                    // Establecer dimensiones pequeñas para obtener colores representativos
                    canvas.width = 10;
                    canvas.height = 10;
                    ctx.drawImage(img, 0, 0, 10, 10);

                    // Función para obtener el color en una posición específica de la imagen
                    function getColorAt(x, y) {
                        const imageData = ctx.getImageData(x, y, 1, 1).data;
                        return { r: imageData[0], g: imageData[1], b: imageData[2] };
                    }

                    let primaryColor = getColorAt(5, 5); // El centro de la imagen

                    // Función para calcular la luminosidad de un color
                    function getBrightness(color) {
                        return (color.r * 0.299 + color.g * 0.587 + color.b * 0.114);
                    }

                    // Función para oscurecer un color
                    function darkenColor(color, amount) {
                        let r = Math.max(0, color.r - amount);
                        let g = Math.max(0, color.g - amount);
                        let b = Math.max(0, color.b - amount);
                        return `rgba(${Math.floor(r)}, ${Math.floor(g)}, ${Math.floor(b)}, 1)`;
                    }

                    // Función para aclarar un color
                    function lightenColor(color, amount) {
                        let r = Math.min(255, color.r + amount);
                        let g = Math.min(255, color.g + amount);
                        let b = Math.min(255, color.b + amount);
                        return `rgba(${Math.floor(r)}, ${Math.floor(g)}, ${Math.floor(b)}, 1)`;
                    }

                    // Ajustamos el color dependiendo de la luminosidad
                    let finalGradientColor;
                    const brightness = getBrightness(primaryColor);
                    if (brightness < 128) {
                        finalGradientColor = lightenColor(primaryColor, 50); // Aclarar si es oscuro
                    } else {
                        finalGradientColor = darkenColor(primaryColor, 50); // Oscurecer si es claro
                    }

                    // Asegurarte de que finalGradientColor tenga formato rgba
                    function adjustOpacity(color, opacity) {
                        // Desglosamos el color para cambiar la opacidad
                        return color.replace(/rgba\((\d+), (\d+), (\d+), ([\d.]+)\)/, (match, r, g, b) => {
                            return `rgba(${r}, ${g}, ${b}, ${opacity})`;
                        });
                    }

                    let finalGradientColorWithOpacity = adjustOpacity(finalGradientColor, 0.7);

                    // Aplicar el nuevo gradiente al fondo
                    eventoBanner.style.backgroundImage = `
                        linear-gradient(to top, ${finalGradientColorWithOpacity}, rgba(0, 0, 0, 0.01) 70%),
                        linear-gradient(to bottom, ${finalGradientColorWithOpacity}, rgba(0, 0, 0, 0.1) 70%), 
                        url('${imgUrl}')
                    `;
                };
            });
        </script>

        <!-- Plan gradient -->
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const cards = document.querySelectorAll(".plan-img"); // Cambié de .evento-card a .plan-img

                cards.forEach(card => {
                    const parentContainer = card.closest('.contenedor-plan-info'); // Buscar el contenedor padre
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

                            //card.style.boxShadow = `5px 5px 10px ${finalShadowColor.replace(/rgba\((\d+), (\d+), (\d+), 1\)/, (match, r, g, b) => `rgba(${r}, ${g}, ${b}, 1.5)`)}`;

                            // 🔹 Aplicar el color más adecuado
                            card.style.backgroundImage = `
                                linear-gradient(to top, ${finalShadowColor}, rgba(0, 0, 0, 0.05) 100%),
                                url('${imgUrl}')
                            `;

                            if (parentContainer) {
                                parentContainer.style.backgroundColor = finalShadowColor;
                            }
                        };
                    }
                });
            });
        </script>

        <!-- AOS Library -->
        <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
        <script>
            AOS.init();
        </script>
    </body>
</html>