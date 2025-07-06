@component('mail::message')
# New Booking Notification

A new booking has been made with the following details:

- **Name:** {{ $booking->name }}
- **Email:** {{ $booking->email }}
- **Phone:** {{ $booking->phone }}
- **Ticket Type:** {{ ucfirst($booking->ticket_type) }}
- **Final Price:** ${{ $booking->final_price }}
- **Promo Code:** {{ $booking->promo_code ?? 'N/A' }}
- **Country:** {{ $booking->country }}
- **Organization:** {{ $booking->organization ?? 'N/A' }}
- **Booking Date:** {{ $booking->created_at->format('Y-m-d H:i') }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent