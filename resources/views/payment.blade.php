<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Formulario de Pago</title>
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
    <h1>Formulario de Pago con Stripe V1</h1>

    <!-- Mostrar el precio y la descripción del plan -->
    <h2 style="margin: 10px; font-weight: bold">{{ $plan->precio }} €</h2>
    <p><?= htmlspecialchars_decode($plan->descripcion) ?></p>

    <!-- Formulario de pago -->
    <form id="payment-form" method="POST" action="{{ route('payment.createPaymentIntent') }}">
        @csrf
        <!-- Enviar el precio como un campo oculto -->
        <input type="hidden" name="price" value="{{ $plan->precio }}">

        <div id="card-element">
            <!-- Un elemento de tarjeta de crédito de Stripe -->
        </div>

        <button id="submit">Pagar</button>
        <p id="error-message"></p>
    </form>

    <script>
        var csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (!csrfToken) {
            console.error('No CSRF token found!');
        } else {
            var stripe = Stripe("{{ env('STRIPE_KEY') }}");
            var elements = stripe.elements();
            var card = elements.create("card");

            card.mount("#card-element");

            var form = document.getElementById("payment-form");

            form.addEventListener("submit", async function(event) {
                event.preventDefault();
    
                // Enviar la solicitud para crear un PaymentIntent
                const response = await fetch("{{ route('payment.createPaymentIntent') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken.content, // CSRF token
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
                            name: "Cliente",
                        },
                    },
                });

                if (error) {
                    document.getElementById("error-message").innerText = error.message;
                } else {
                    if (paymentIntent.status === "succeeded") {
                        alert("Pago realizado exitosamente");
                    }
                }
            });
        }
    </script>
</body>
</html>
