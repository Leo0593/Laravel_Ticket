<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.head')
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="https://js.stripe.com/v3/"></script>
    </head>
    <body>
        @include('layouts.header')
        
        <div class="main" style="display: flex !important; flex-direction: row !important; flex-wrap: wrap; height: 100%;">
            <!-- Formulario de pago -->
            <div style="width:70%; height: 100%;">
                <div id="banner"
                    style="background-color:rgb(132, 132, 132); 
                    height: 28%; width: 100%;
                    padding: 20px; display: flex; flex-direction: row;
                    box-shadow: 0px 10px 15px 0 rgba(0, 0, 0, 0.4);
                    "
                    data-aos="fade-down" data-aos-duration="1000" 
                    > 
                    
                    <div id="eventoFotoUrl"
                        style="background-color: white;
                        height: 100%; width: 400px;
                        background-image: url('{{ $plan->evento->Foto ? asset('storage/' . $plan->evento->Foto) : 'https://placehold.co/600x400' }}');  
                        background-size: cover;
                        background-position: center;
                        background-repeat: no-repeat;
                        margin-right: 20px; border-radius: 10px;
                        box-shadow: -10px -5px 15px 0 rgba(0, 0, 0, 0.4);
                        ">
                    </div>

                    <div style="display: flex; flex-direction: column; justify-content: center; align-items: flex-start; gap: 8px;">
                        <h1 class="sub-titulo" style="font-size: 1.5rem; margin-bottom: 0px;">{{ $plan->evento->ArtistaGrupo }}</h1>
                        <h1 class="titulo" style="font-size: 2.5rem; margin-bottom: 0px;">{{ $plan->evento->nombre }}</h1>
                        <p style="font-size: 1.2rem; margin-bottom: 0px;">
                            {{ ucfirst(\Carbon\Carbon::parse($plan->evento->fecha_evento)->locale('es')->isoFormat('ddd, D MMM Y, HH:mm')) }}
                        </p>
                        <p style="font-size: 1.7rem; margin-bottom: 0px;">{{ $plan->evento->local->Nombre }}</p>
                    </div>
                </div>

                <div style="padding: 0 30px; margin-top: 60px; width: 100%; display: flex; justify-content: center;">
                    @auth
                        <div style="width: 80%; height: auto; 
                            border-radius: 10px; border: 1px solid var(--color);
                            box-shadow: 0px 10px 15px 0 rgba(0, 0, 0, 0.4);
                            overflow: hidden; "
                            data-aos="zoom-in" data-aos-duration="1000" 
                            >
                            <div style="background-color: var(--color); color: white; font-size: 1.5rem; font-weight: bold;
                                width: 100%; height: auto; padding: 20px; text-align: center;
                                
                                ">
                                COMPRAR ENTRADA
                            </div>

                            <div style="padding: 40px; text-align: center; font-size: 1.2rem;">
                                <!-- Formulario de pago SOLO para usuarios autenticados -->
                                <form id="payment-form" method="POST" action="{{ route('payment.createPaymentIntent') }}">
                                    @csrf
                                    @method('POST')

                                    <p>Asientos disponibles: {{ $plan->asientosDisponibles->count() }}</p>

                                    <div style="width: 100%; text-align: left; margin-bottom: 5px;">
                                        <label for="asiento-{{ $plan->id }}">Selecciona tu asiento:</label>
                                    </div>
                                    <div class="input-container" style="margin-bottom: 20px;">
                                        <i class="fa-solid fa-chair"></i>
                                        <select class="input_1" style="--borderColor: var(--color);" name="asiento" id="asiento-{{ $plan->id }}" required>
                                            <option value="" disabled selected>Selecciona un asiento</option>
                                            @if(isset($plan->asientosDisponibles) && $plan->asientosDisponibles->isNotEmpty())
                                                @foreach($plan->asientosDisponibles as $asiento)
                                                    <option value="{{ $asiento->id }}">Asiento #{{ $asiento->numero_asiento }}</option>
                                                @endforeach
                                            @else
                                                <option disabled>No hay asientos disponibles</option>
                                            @endif
                                        </select>
                                    </div>


                                    <input type="hidden" id="id_plan" value="{{ $plan->id }}">
                                    <input type="hidden" id="price" name="price" value="{{ $plan->precio }}">
                                    <input type="hidden" id="id_evento" value="{{ $plan->evento_id }}">
                                    <input type="hidden" id="id_usuario" value="{{ auth()->user()->id }}">

                                    <div id="card-element">
                                        <!-- Un elemento de tarjeta de crédito de Stripe -->
                                    </div>


                                    <button class="btn-1 scale" style="background-color: var(--color);" id="submit">Pagar</button>
                                    <p id="error-message"></p>
                                </form>
                            </div>
                        </div>
                    @else
                        <div style="width: 100%; height: auto; 
                            border-radius: 10px; border: 1px solid var(--color);
                            box-shadow: 0px 10px 15px 0 rgba(0, 0, 0, 0.4);
                            overflow: hidden; "
                            data-aos="zoom-in" data-aos-duration="1000" 
                            >
                            <div style="background-color: var(--color); color: white; font-size: 1.5rem; font-weight: bold;
                                width: 100%; height: auto; padding: 20px; text-align: center;
                                ">
                                COMPRAR ENTRADA
                            </div>

                            <div style="padding: 40px; text-align: center; font-size: 1.2rem;">
                                <p>Para realizar el pago, por favor, accede a tu cuenta</p>
                                <a href="{{ route('login') }}">
                                    <button class="btn btn-primary scale">
                                        <i class="fa-solid fa-user"></i>
                                        Accede
                                    </button>
                                </a>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>

            <!-- Detalles de la compra -->
            <div data-aos="fade-left" data-aos-duration="1000"  
                style="width:30%; height: 100%; display: flex; flex-direction: column; box-shadow: -10px -5px 15px 0 rgba(0, 0, 0, 0.4); border-radius: 10px;">
                <!-- Imagen -->
                <div id="plan-img" 
                    style="width: 100%; height: 50%;
                    background-image: linear-gradient(to top, rgb(255, 255, 255), rgba(0, 0, 0, 0.05) 80%),
                    url('{{ $plan->Foto ? asset('storage/' . $plan->Foto) : 'https://placehold.co/600x400' }}');
                    background-size: cover;
                    background-position: center;
                    background-repeat: no-repeat;
                    ">
                </div>
                <!-- Detalles -->
                <div id="contenedor-plan-info"  
                    style="width: 100%; height: 50%; padding: 30px; display: flex; flex-direction: column; align-items: center; text-align: center; justify-content: center;">
                    <h4>{{ $plan->tipo }}</h4>
                    <h2 style="margin: 10px; font-weight: bold">{{ $plan->precio }} €</h2>
                    <p><?= htmlspecialchars_decode($plan->descripcion) ?></p>
                </div>
            </div>
        </div>

        <script>
                document.addEventListener("DOMContentLoaded", function () {
                const id_plan = document.getElementById("id_plan");
                const price = document.getElementById("price");
                const id_evento = document.getElementById("id_evento");
                const id_usuario = document.getElementById("id_usuario");
                const asientoSelect = document.querySelector("[id^=asiento-]");

                if (!price || !id_evento || !id_usuario || !asientoSelect || !id_plan) {
                    console.error("Algunos de los elementos necesarios no existen en el DOM.");
                    return;
                }

                var stripe = Stripe("{{ env('STRIPE_KEY') }}");
                var elements = stripe.elements();
                var card = elements.create("card");

                card.mount("#card-element");

                var form = document.getElementById("payment-form");

                form.addEventListener("submit", async function(event) {
                    event.preventDefault();

                    const asientoSelect = document.querySelector("[id^=asiento-]");
                    const asientoValue = asientoSelect ? asientoSelect.value : null;

                    if (!asientoValue) {
                        document.getElementById("error-message").innerText = "Por favor, selecciona un asiento.";
                        return;
                    }

                    const response = await fetch("{{ route('payment.createPaymentIntent') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                        },
                        body: JSON.stringify({
                            price: form.querySelector('input[name="price"]').value
                        })
                    });

                    const data = await response.json();
                    const { clientSecret } = data;

                    const { error, paymentIntent } = await stripe.confirmCardPayment(clientSecret, {
                        payment_method: {
                            card: card,
                            billing_details: {
                                name: "TICKETS",
                            },
                        },
                    });

                    if (error) {
                        document.getElementById("error-message").innerText = error.message;
                    } else {
                        if (paymentIntent.status === "succeeded") {
                            alert("Pago realizado exitosamente");

                            let ticketData = {
                                user_id: document.getElementById("id_usuario").value,
                                evento_id: document.getElementById("id_evento").value,
                                asiento_id: asientoValue,
                                plan_id: document.getElementById("id_plan").value,
                                qr: null,
                                qr_valido: 1,
                                pagado: 1,
                            };

                            fetch("/tickets/store", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                            },
                        body: JSON.stringify(ticketData)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert("Ticket creado exitosamente");

                            let ticketUrl = "{{ route('tickets.ticket.mostrar', ['id' => ':id', 'codigo' => ':codigo']) }}";
                            ticketUrl = ticketUrl.replace(':id', data.ticket.id).replace(':codigo', data.ticket.qr);
                            window.location.href = ticketUrl;
                        } else {
                            alert("Error al crear el ticket: " + data.error);
                        }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        alert("Error al crear el ticket. Inténtelo de nuevo.");
                    });
                                }
                            }
                        });
                    });
        </script>

        <!-- Color de fondo Evento -->
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const eventoBanner = document.getElementById("banner");
                const eventoFotoDiv = document.getElementById("eventoFotoUrl");

                // Obtener la URL de la imagen desde el background-image del div
                let imgUrl = window.getComputedStyle(eventoFotoDiv).backgroundImage;

                // Extraer la URL eliminando "url()" y comillas
                imgUrl = imgUrl.replace(/^url\(["']?/, '').replace(/["']?\)$/, '');

                // Verificar si hay una URL válida
                if (!imgUrl || imgUrl === "none") {
                    console.error("No se encontró una imagen de fondo válida.");
                    return;
                }

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

                    // Función para oscurecer o aclarar un color
                    function adjustColor(color, amount, lighten = false) {
                        let r = lighten ? Math.min(255, color.r + amount) : Math.max(0, color.r - amount);
                        let g = lighten ? Math.min(255, color.g + amount) : Math.max(0, color.g - amount);
                        let b = lighten ? Math.min(255, color.b + amount) : Math.max(0, color.b - amount);
                        return `rgb(${Math.floor(r)}, ${Math.floor(g)}, ${Math.floor(b)})`;
                    }

                    // Ajustar color según su brillo
                    const brightness = getBrightness(primaryColor);
                    let finalColor = brightness < 128 
                        ? adjustColor(primaryColor, 50, true)  // Aclarar si es oscuro
                        : adjustColor(primaryColor, 50, false); // Oscurecer si es claro

                    // Aplicar el color sólido al fondo
                    eventoBanner.style.backgroundColor = finalColor;

                    // Cambiar el color del texto a blanco si el fondo es demasiado oscuro
                    const textColor = brightness < 100 ? "#ffffff" : "#000000";
                    eventoBanner.style.color = textColor;
                };

                img.onerror = function () {
                    console.error("Error al cargar la imagen.");
                };
            });
        </script>

        <!-- Color de fondo Plan -->

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const planImg = document.getElementById("plan-img");
                const planInfo = document.getElementById("contenedor-plan-info");

                const imgUrl = planImg.style.backgroundImage.match(/url\(["']?([^"']+)["']?\)/)[1];

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

                        // Aplicar el color más adecuado
                        planImg.style.backgroundImage = `
                            linear-gradient(to top, ${finalShadowColor}, rgba(0, 0, 0, 0.05) 100%),
                            url('${imgUrl}')
                        `;

                        if (planInfo) {
                            planInfo.style.backgroundColor = finalShadowColor;
                        }
                    };
                }
            });
        </script>
    </body>
</html>