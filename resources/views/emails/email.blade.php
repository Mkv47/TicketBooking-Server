<h2>Booking Confirmation</h2>
<p>Thank you, {{ $booking->name }}!</p>
<p>Your booking has been confirmed with the following details:</p>

<ul>
    <li>Email: {{ $booking->email }}</li>
    <li>Phone: {{ $booking->phone }}</li>
    <li>Ticket Type: {{ $booking->ticket_type }}</li>
    <li>Final Price: ${{ $booking->final_price }}</li>
    <li>Promo Code: {{ $booking->promo_code ?? 'N/A' }}</li>
    <li>Country: {{ $booking->country }}</li>
    <li>Organization: {{ $booking->organization ?? 'N/A' }}</li>
</ul>

<p>We look forward to seeing you!</p>