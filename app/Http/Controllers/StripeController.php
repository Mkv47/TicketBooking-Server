<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use App\Models\Booking;
use App\Mail\BookingConfirmation;
use App\Mail\AdminBookingNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\MailException;
use Illuminate\Support\Facades\Validator;

class StripeController extends Controller
{
    public function checkout()
    {
        return view('stripe.checkout');
    }

    public function session(Request $request)
    {
        // 1. Sanitize input
        $input = $request->only([
            'name', 'email', 'phone', 'ticket_type', 'promo_code', 'country', 'organization'
        ]);

        $input = array_map(function ($value) {
            return is_string($value) ? trim(strip_tags($value)) : $value;
        }, $input);

        // 2. Validate input
        $validator = Validator::make($input, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:bookings,email',
            'phone' => 'required|string|unique:bookings,phone',
            'ticket_type' => 'required|in:general,student,vip,group',
            'country' => 'required|string',
            'organization' => 'nullable|string',
            'promo_code' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();

        // 3. Price logic
        $prices = [
            'general' => 50,
            'student' => 30,
            'vip' => 100,
            'group' => 200,
        ];

        $discounts = [
            'SAVE10' => 0.10,
            'EVENT20' => 0.20,
        ];

        $price = $prices[$validated['ticket_type']];
        $promoCode = strtoupper($validated['promo_code'] ?? '');
        if ($promoCode && isset($discounts[$promoCode])) {
            $price -= $price * $discounts[$promoCode];
        }

        $validated['final_price'] = number_format($price, 2, '.', '');
        $validated['promo_code'] = $promoCode ?: null;

        // 4. Send to Stripe
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = Session::create([
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => ['name' => 'Ticket Booking'],
                    'unit_amount' => $validated['final_price'] * 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('stripe.cancel'),
            'metadata' => [
                'booking' => json_encode($validated),
            ],
        ]);

        return response()->json(['url' => $session->url]);
    }

    public function success(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
    
        $sessionId = $request->query('session_id');
        if (!$sessionId) {
            return redirect('/');
        }
    
        $session = Session::retrieve($sessionId);
    
        $bookingDataJson = $session->metadata->booking ?? null;
        if (!$bookingDataJson) {
            return redirect('/');
        }
    
        $bookingData = json_decode($bookingDataJson, true);
    
        // Store booking
        $booking = Booking::create($bookingData);
    
        // Prepare email error message container
        $emailErrorMessage = null;
    
        try {
            Mail::to($booking->email)->send(new BookingConfirmation($booking));
            Mail::to(env('MAIL_ADMIN_ADDRESS'))->send(new AdminBookingNotification($booking));
        } catch (\Exception $e) {
            // Log error or ignore as you wish
            $emailErrorMessage = "⚠️ Mailtrap or mail configuration is not set correctly.";
        }
    
        // Prepare QR code with detailed booking info
        $qrData = "Booking Confirmation\n";
        $qrData .= "ID: {$booking->id}\n";
        $qrData .= "Name: {$booking->name}\n";
        $qrData .= "Email: {$booking->email}\n";
        $qrData .= "Phone: {$booking->phone}\n";
        $qrData .= "Ticket Type: {$booking->ticket_type}\n";
        $qrData .= "Price: \${$booking->final_price}\n";
        $qrData .= "Country: {$booking->country}\n";
        if ($booking->organization) {
            $qrData .= "Organization: {$booking->organization}\n";
        }
        if ($booking->promo_code) {
            $qrData .= "Promo Code: {$booking->promo_code}\n";
        }
    
        $qr = Builder::create()
            ->writer(new PngWriter())
            ->data($qrData)
            ->size(200)
            ->build();
    
        $base64 = base64_encode($qr->getString());
    
        return view('stripe.success', [
            'qrCode' => $base64,
            'message' => 'Thank you for your payment!',
            'booking' => $booking,
            'emailError' => $emailErrorMessage,  // Pass error message to view
        ]);
    }

    public function cancel()
    {
        return 'Payment canceled.';
    }
}