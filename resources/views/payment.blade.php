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

    <form id="payment-form" method="POST" action="{{ url('create-payment-intent') }}">
        @csrf  <!-- Esto incluye el CSRF token -->
        <div id="card-element">
            <!-- Un elemento de tarjeta de crédito de Stripe -->
        </div>
        <button id="submit">Pagar</button>
        <p id="error-message"></p>
    </form>

    <script>
        // Verifica que el token CSRF esté presente
        var csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (!csrfToken) {
            console.error('No CSRF token found!');
        } else {
            // Configura tu Stripe
            var stripe = Stripe("{{ env('STRIPE_KEY') }}");
            var elements = stripe.elements();
            var card = elements.create("card");

            card.mount("#card-element");

            // Manejar el envío del formulario
            var form = document.getElementById("payment-form");

            form.addEventListener("submit", async function(event) {
                event.preventDefault();

                // Enviar la solicitud para crear un PaymentIntent
                const response = await fetch("/create-payment-intent", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken.content, // CSRF token
                    },
                    body: JSON.stringify({})
                });

                const data = await response.json();
                const { clientSecret } = data;

                // Confirmar el pago
                const { error, paymentIntent } = await stripe.confirmCardPayment(clientSecret, {
                    payment_method: {
                        card: card,
                        billing_details: {
                            name: "Cliente",
                        },
                    },
                });

                if (error) {
                    // Muestra el error al usuario
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
