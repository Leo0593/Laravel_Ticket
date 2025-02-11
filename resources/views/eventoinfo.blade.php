<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('layouts.head')
    
    <body>
        @include('layouts.header')

        <div class="main">
            <div class="main_banner_2 evento-card" 
                style="
                    background-image: 
                    linear-gradient(to top, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7) 100%),
                    linear-gradient(to bottom, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7) 100%), 
                    url('{{ $evento->Foto ? asset('storage/' . $evento->Foto) : 'https://placehold.co/600x400' }}');                
                    background-size: cover;
                    background-position: center;
                    height: 400px;
                    display: flex;
                    align-items: flex-start;
                    justify-content: space-between;
                    text-shadow: 4px 4px 5px rgba(0, 0, 0, 0.8);
                    padding: 40px 100px;
                    ">
                <h1><strong>{{ $evento->ArtistaGrupo }}</strong></h1>
                <h1><strong>{{ $evento->nombre }}</strong></h1>
            </div>

            <div style="background-color: rgb(246, 246, 246); 
                width: 100%;
                display: flex;
                flex-direction: column;
                align-items: center;
                flex-grow: 1;
                ">

                <div style=" 
                width: 100%;
                padding: 5px 150px; 
                background-color: white;
                box-shadow: 0 5px 20px rgba(0, 0, 0, 0.4);
                ">
                    <nav class="nav">
                        <a class="nav-link" href="#">FECHA</a>
                        <a class="nav-link" href="#">INFO</a>
                        <a class="nav-link" href="#">ENTRADAS</a>
                    </nav>
                </div>

                <div class="m-5"
                    style="
                    width: 70%;
                    background-color: white;
                    padding: 20px 50px;
                    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.4);
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
                            <button class="btn-1" style="border: 2px solid #000; color: #000;">
                                <i class="fa-solid fa-cart-plus" style="margin-right: 8px"></i>
                                Entradas
                            </button>
                        </div>
                    </div>
                </div>

                <div class="m-5"
                    style="
                    width: 70%;
                    background-color: white;
                    padding: 20px 50px;
                    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.4);
                    ">

                    <div class="eventos-title-container">
                        <h2 class="eventos-title">INFO</h2>
                    </div>

                    <p><?= htmlspecialchars_decode($evento->descripcion) ?></p>
                </div>

                <div class="m-5"
                    style="
                    width: 70%;
                    background-color: white;
                    padding: 20px 50px;
                    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.4);
                    ">

                    <div class="eventos-title-container">
                        <h2 class="eventos-title">ENTRADAS</h2>
                    </div>

                        @foreach($evento->planes as $plan)
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

                                <!-- Información -->
                                <div 
                                    style="flex: 1 1 50%;
                                    display: flex;
                                    flex-direction: column;
                                    justify-content: space-between;
                                    ">

                                    <!-- Header -->
                                    <div 
                                        style="background-color: rgb(246, 246, 246);
                                        width: 100%;
                                        height: auto;
                                        padding: 5px 10px;
                                        border-bottom: 1px solid rgba(0, 0, 0, 0.175);
                                        text-align: center;
                                        ">
                                        <h4">{{ $plan->tipo }}</h4>
                                    </div>

                                    <!-- Descripcion -->
                                    <div 
                                        style="
                                        width: 100%;
                                        height: auto;
                                        padding: 10px 30px;
                                        text-align: center;
                                        flex-grow: 1;
                                        ">
                                        <h2 style="margin: 10px; font-weight: bold">{{ $plan->precio }} €</h2>
                                        <p>{{ $plan->descripcion }}</p>
                                    </div>
                                </div>

                                <!-- Imagen -->
                                <div 
                                    style="
                                    flex: 1 1 50%;

                                    background-image: url('{{ $plan->Foto ? asset('storage/' . $plan->Foto) : 'https://placehold.co/600x400' }}');
                                    background-size: cover;
                                    background-position: center;
                                    background-repeat: no-repeat;
                                    ">
                                </div>
                            </div>
                        @endforeach
                    
                </div>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const card = document.querySelector(".evento-card");

                if (card) {
                    // Extraer la URL de fondo de `background-image`
                    let bgImage = card.style.backgroundImage;
                    let matches = bgImage.match(/url\(["']?(.*?)["']?\)/);
                    let imgUrl = matches ? matches[1] : null;

                    if (imgUrl) {
                        const img = new Image();
                        img.crossOrigin = "Anonymous";
                        img.src = imgUrl;

                        img.onload = function () {
                            const canvas = document.createElement("canvas");
                            const ctx = canvas.getContext("2d");

                            canvas.width = 10;
                            canvas.height = 10;
                            ctx.drawImage(img, 0, 0, 10, 10);

                            const imageData = ctx.getImageData(5, 5, 1, 1).data; // Tomar el color central
                            let r = imageData[0];
                            let g = imageData[1];
                            let b = imageData[2];

                            // 🔹 Aumentar la luminosidad
                            r = Math.min(255, r + 50);
                            g = Math.min(255, g + 50);
                            b = Math.min(255, b + 50);

                            // 🔹 Aumentar la saturación
                            const factor = 1;
                            r = Math.min(255, r * factor);
                            g = Math.min(255, g * factor);
                            b = Math.min(255, b * factor);

                            const color = `rgba(${Math.floor(r)}, ${Math.floor(g)}, ${Math.floor(b)}, 0.3)`;

                            // Aplicar la sombra y el nuevo gradiente
                            card.style.boxShadow = `3px 5px 15px ${color}`;
                            card.style.backgroundImage = `
                                linear-gradient(to top, ${color}, rgba(0, 0, 0, 0.2) 60%),
                                linear-gradient(to bottom, ${color}, rgba(0, 0, 0, 0.2) 60%), 
                                url('${imgUrl}')
                            `;
                        };
                    }
                }
            });
        </script>
    </body>
</html>