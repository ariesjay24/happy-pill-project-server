<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $bookingDetails;

    public function __construct($bookingDetails)
    {
        $this->bookingDetails = $bookingDetails;
    }

    public function build()
    {
        return $this->view('emails.booking')
                    ->with('details', $this->bookingDetails);
    }
}
