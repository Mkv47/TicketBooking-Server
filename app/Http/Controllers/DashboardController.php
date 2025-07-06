<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->input('type', 'all');
        $query = \App\Models\Booking::query();

        if ($type && $type !== 'all') {
            $query->where('ticket_type', $type);
        }

        $bookings = $query->orderByDesc('created_at')->get();

        return view('admin', [
            'bookings' => $bookings,
            'ticketType' => $type,
            'totalBookings' => $query->count(),
            'totalRevenue' => $query->sum('final_price'),
        ]);
    }

    public function export(Request $request): StreamedResponse
    {
        $ticketType = $request->query('type');
        $query = Booking::query();

        if ($ticketType) {
            $query->where('ticket_type', $ticketType);
        }

        $bookings = $query->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="bookings.csv"',
        ];

        $callback = function () use ($bookings) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Name', 'Email', 'Phone', 'Ticket Type', 'Price', 'Country', 'Promo Code', 'Created At']);

            foreach ($bookings as $booking) {
                fputcsv($handle, [
                    $booking->name,
                    $booking->email,
                    $booking->phone,
                    $booking->ticket_type,
                    $booking->final_price,
                    $booking->country,
                    $booking->promo_code ?? 'N/A',
                    $booking->created_at,
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}