<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Validator;
use App\Mail\BookingConfirmation;
use App\Mail\AdminBookingNotification;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        // Sanitize inputs first
        $input = $request->all();
        $input['name'] = isset($input['name']) ? trim(strip_tags($input['name'])) : null;
        $input['email'] = isset($input['email']) ? trim($input['email']) : null;
        $input['phone'] = isset($input['phone']) ? trim(strip_tags($input['phone'])) : null;
        $input['ticket_type'] = isset($input['ticket_type']) ? trim(strip_tags($input['ticket_type'])) : null;
        $input['promo_code'] = isset($input['promo_code']) ? trim(strip_tags($input['promo_code'])) : null;
        $input['country'] = isset($input['country']) ? trim(strip_tags($input['country'])) : null;
        $input['organization'] = isset($input['organization']) ? trim(strip_tags($input['organization'])) : null;

        // Now validate sanitized input
        $validator = Validator::make($input, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:bookings,email',
            'phone' => 'required|string|unique:bookings,phone',
            'ticket_type' => 'required|string|in:general,student,vip,group',
            'country' => 'required|string',
            'organization' => 'nullable|string',
            'promo_code' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();

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

        $price = $prices[$validated['ticket_type']] ?? 0;
        $promoCode = strtoupper($validated['promo_code'] ?? '');

        if ($promoCode && isset($discounts[$promoCode])) {
            $price -= $price * $discounts[$promoCode];
        }

        $validated['final_price'] = number_format($price, 2, '.', '');
        $validated['promo_code'] = $promoCode ?: null;

        $booking = Booking::create($validated);

        Mail::to($booking->email)->send(new BookingConfirmation($booking));
        Mail::to(env('MAIL_ADMIN_ADDRESS', 'Mohammedad.work@gmail.com'))->send(new AdminBookingNotification($booking));
        
        return response()->json([
            'message' => 'Booking successful!',
            'booking_id' => $booking->id
        ]);
    }

    public function getPrice(Request $request)
    {
        $validated = $request->validate([
            'ticket_type' => 'required|in:general,student,vip,group',
            'promo_code' => 'nullable|string|max:20',
        ]);
    
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
    
        if (isset($discounts[$promoCode])) {
            $price -= $price * $discounts[$promoCode];
        }
    
        return response()->json([
            'price' => number_format($price, 2, '.', ''),
        ]);
    }
}