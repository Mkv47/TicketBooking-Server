<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Booking;

class AdminBookingNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;  // make this public so it's available in the view

    /**
     * Create a new message instance.
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;  // assign it here
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->markdown('emails.admin_booking_notification');
    }
}