<?php

namespace App\Http\Controllers;
use Stripe\StripeClient;

class PaymentController extends Controller
{
    protected $stripe;

    public function __construct(StripeClient $stripe)
    {
        $this->stripe = $stripe;
    }

    public function createPaymentIntent()
    {
        $paymentIntent = $this->stripe->paymentIntents->create([
            'amount' => 1000, // amount in cents
            'currency' => 'usd',
            'payment_method_types' => ['card'],
        ]);

        return response()->json($paymentIntent);
    }
}
