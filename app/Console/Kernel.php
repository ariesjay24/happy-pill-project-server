<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Services\SemaphoreService;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            Log::info('Scheduled task running');
            
            $tomorrow = Carbon::tomorrow()->toDateString();
            Log::info('Checking bookings for date: ' . $tomorrow);
            
            $bookings = Booking::with('user', 'service')
                ->where('BookingDate', $tomorrow)
                ->get();

            foreach ($bookings as $booking) {
                $user = $booking->user;
                if ($user) {
                    $message = "Reminder: Your booking for {$booking->service->Name} on {$booking->BookingDate} at {$booking->BookingTime} is tomorrow.";
                    Log::info("Sending reminder to {$user->PhoneNumber} with message: {$message}");
                    $response = app(SemaphoreService::class)->sendSms($user->PhoneNumber, $message);
                    Log::info("SMS Response: " . json_encode($response));
                }
            }

            Log::info('Booking reminders have been sent successfully.');
        })->everyMinute(); // Adjust this to the time you want the task to run daily
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
