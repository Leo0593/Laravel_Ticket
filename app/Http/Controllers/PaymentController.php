<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;


class PaymentController extends Controller
{
    public function index()
    {
        return view('payment');
    }

    public function createPaymentIntent(Request $request)
    {
        // Configura la clave secreta de Stripe
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Crea un PaymentIntent
        $paymentIntent = PaymentIntent::create([
            'amount' => 1000, // El monto en centavos (ejemplo 10 USD)
            'currency' => 'usd',
            'payment_method_types' => ['card'],
        ]);

        return response()->json([
            'clientSecret' => $paymentIntent->client_secret
        ]);
    }
}
