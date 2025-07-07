<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookingController extends Controller
{
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