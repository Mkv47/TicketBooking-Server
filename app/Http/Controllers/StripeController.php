<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

class StripeController extends Controller
{
    public function checkout()
    {
        return view('stripe.checkout');
    }

    public function session(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = Session::create([
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Ticket Booking',
                    ],
                    'unit_amount' => $request->amount * 100, // in cents
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('stripe.success'),
            'cancel_url' => route('stripe.cancel'),
        ]);

        return redirect($session->url);
    }

    public function success()
    {
        $qr = Builder::create()
            ->writer(new PngWriter())
            ->data('Payment confirmed. Booking ID: 12345')
            ->size(200)
            ->build();

        $base64 = base64_encode($qr->getString());

        return view('stripe.success', [
            'qrCode' => $base64,
            'message' => 'Thank you for your payment!',
        ]);
    }

    public function cancel()
    {
        return 'Payment canceled.';
    }
}