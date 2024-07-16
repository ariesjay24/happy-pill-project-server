<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use App\Services\SemaphoreService;
use Carbon\Carbon;

class SendBookingReminders extends Command
{
    protected $signature = 'send:booking-reminders';
    protected $description = 'Send reminders for upcoming bookings';

    protected $semaphoreService;

    public function __construct(SemaphoreService $semaphoreService)
    {
        parent::__construct();
        $this->semaphoreService = $semaphoreService;
    }

    public function handle()
    {
        // Get bookings for the next day
        $tomorrow = Carbon::tomorrow()->toDateString();
        $bookings = Booking::with('user', 'service')
            ->where('BookingDate', $tomorrow)
            ->get();

        foreach ($bookings as $booking) {
            $message = "Reminder: Your booking for {$booking->service->Name} on {$booking->BookingDate} at {$booking->BookingTime} is tomorrow.";
            $this->semaphoreService->sendSms($booking->user->PhoneNumber, $message);
        }

        $this->info('Booking reminders have been sent successfully.');
    }
}
