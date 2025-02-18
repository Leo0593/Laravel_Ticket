<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use App\Models\M_Plan;

class PaymentController extends Controller
{
    public function index($planId)
    {
        // Obtén el plan desde la base de datos usando el planId
        $plan = M_Plan::find($planId);  // Asegúrate de que `Plan` sea tu modelo de planes

        return view('payment', compact('plan')); // Pasa el plan a la vista
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
}

