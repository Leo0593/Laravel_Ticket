<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.head')
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="https://js.stripe.com/v3/"></script>
    </head>
    <body>
        @include('layouts.header')

        <div>
            <h1>Formulario de Pago con Stripe V1</h1>

            <!-- Mostrar el precio y la descripción del plan -->
            <h2 style="margin: 10px; font-weight: bold">{{ $plan->precio }} €</h2>
            <p><?= htmlspecialchars_decode($plan->descripcion) ?></p>

            <label for="asiento-{{ $plan->id }}">Selecciona tu asiento:</label>
            <select name="asiento" id="asiento-{{ $plan->id }}" required>
                <option value="" disabled selected>Selecciona un asiento</option>
                @if(isset($plan->asientosDisponibles) && $plan->asientosDisponibles->isNotEmpty())
                    @foreach($plan->asientosDisponibles as $asiento)
                        <option value="{{ $asiento->id }}">Asiento #{{ $asiento->numero_asiento }}</option>
                    @endforeach
                @else
                    <option disabled>No hay asientos disponibles</option>
                @endif
            </select>

            <!-- mostrar todos los asientos que compartan el mismo tipo y evento, en un select -->

            @auth
                <!-- Formulario de pago SOLO para usuarios autenticados -->
                <form id="payment-form" method="POST" action="{{ route('payment.createPaymentIntent') }}">
                    @csrf
                    @method('POST')
                    <input type="hidden" id="id_plan" value="{{ $plan->id }}">
                    <input type="hidden" id="price" name="price" value="{{ $plan->precio }}">
                    <input type="hidden" id="id_evento" value="{{ $plan->evento_id }}">
                    <input type="hidden" id="id_usuario" value="{{ auth()->user()->id }}">

                    <div id="card-element">
                        <!-- Un elemento de tarjeta de crédito de Stripe -->
                    </div>


                    <button id="submit">Pagar</button>
                    <p id="error-message"></p>
                </form>
            @else
                <a href="{{ route('login') }}">
                    <button class="btn btn-primary">
                        <i class="fa-solid fa-user"></i>
                        Accede
                    </button>
                </a>
                <p>Para realizar el pago, por favor, accede a tu cuenta</p>
            @endauth


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
        </div>
    </body>
</html>