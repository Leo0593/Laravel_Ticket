<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Pago</title>
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
    <h1>Formulario de Pago con Stripe</h1>

    <form id="payment-form">
        <div id="card-element">
            <!-- Un elemento de tarjeta de crédito de Stripe -->
        </div>
        <button id="submit">Pagar</button>
        <p id="error-message"></p>
    </form>

    <script>
        // Configura tu Stripe
        var stripe = Stripe("{{ env('STRIPE_KEY') }}");
        var elements = stripe.elements();
        var card = elements.create("card");

        card.mount("#card-element");

        // Manejar el envío del formulario
        var form = document.getElementById("payment-form");

        form.addEventListener("submit", async function(event) {
            event.preventDefault();

            const { clientSecret } = await fetch("/create-payment-intent", {
                method: "POST"
            }).then(function(res) {
                return res.json();
            });

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
    </script>
</body>
</html>
