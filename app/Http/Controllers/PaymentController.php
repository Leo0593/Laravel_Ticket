<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Webhook;
use Stripe\Event;
use App\Models\M_Plan;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function index($planId)
    {
        // Obtén el plan desde la base de datos usando el planId
        $plan = M_Plan::find($planId);  // Asegúrate de que `Plan` sea tu modelo de planes

        return view('layouts.payment.pago', compact('plan')); // Pasa el plan a la vista
    }

    public function createPaymentIntent(Request $request)
    {
        // Configura la clave secreta de Stripe
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Obtener el precio del plan (en centavos)
        $amount = $request->input('price') * 100; // Multiplicamos por 100 para obtener centavos

        // Crea un PaymentIntent con el precio del plan
        $paymentIntent = PaymentIntent::create([
            'amount' => $amount,
            'currency' => 'usd',
            'payment_method_types' => ['card'],
        ]);

        // Retorna el client secret como respuesta JSON
        return response()->json([
            'clientSecret' => $paymentIntent->client_secret
        ]);
    }

    public function handleWebhook(Request $request)
    {
        // Configurar clave secreta de Stripe
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Verificar evento de Stripe
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');

        try {
            $event = Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
        } catch (\Exception $e) {
            Log::error('Error en el webhook: ' . $e->getMessage());
            return response()->json(['error' => 'Webhook error'], 400);        
        }

        // Manejar evento de pago exitoso
        if ($event->type === 'payment_intent.succeeded') {
            $paymentIntent = $event->data->object;

            // Aquí puedes guardar la información del pago en la base de datos
            Log::info('Pago exitoso: ' . $paymentIntent->id);

            // Guardar en la base de datos, enviar email, actualizar suscripción, etc.
        }

        return response()->json(['status' => 'success']);
    }
}

