<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\SemaphoreService;
use App\Services\PayPalService;

class BookingController extends Controller
{
    protected $semaphoreService;
    protected $payPalService;

    public function __construct(SemaphoreService $semaphoreService, PayPalService $payPalService)
    {
        $this->semaphoreService = $semaphoreService;
        $this->payPalService = $payPalService;
    }

    public function index()
    {
        $bookings = Booking::with(['user', 'service'])->get();
        foreach ($bookings as $booking) {
            $booking->user->FullName = $booking->user->FirstName . ' ' . $booking->user->LastName;
            $booking->AddOns = json_decode($booking->AddOns, true) ?? [];
        }
        return response()->json([
            "bookings" => $bookings,
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'userName' => 'required|string',
            'serviceType' => 'required|string',
            'bookingDate' => 'required|date',
            'bookingTime' => 'required|date_format:H:i',
            'location' => 'required|string',
            'addOns' => 'nullable|array',
        ]);
    
        $userNameParts = explode(' ', $request->userName);
        $firstName = $userNameParts[0];
        $lastName = count($userNameParts) > 1 ? $userNameParts[1] : '';
    
        $user = User::where('FirstName', $firstName)->where('LastName', $lastName)->firstOrFail();
        $service = Service::where('Name', $request->serviceType)->firstOrFail();
    
        $totalPrice = $service->Price;
    
        $addOns = [];
        if ($request->addOns) {
            $addOns = Service::whereIn('Name', $request->addOns)->get();
            foreach ($addOns as $addOn) {
                $totalPrice += $addOn->Price;
            }
        }
    
        $booking = Booking::create([
            'UserID' => $user->UserID,
            'ServiceID' => $service->ServiceID,
            'BookingDate' => $request->bookingDate,
            'BookingTime' => $request->bookingTime,
            'Location' => $request->location,
            'AddOns' => $addOns->pluck('Name')->toJson(), // Ensure AddOns are saved as JSON
            'Price' => $totalPrice,
            'Status' => 'Pending',
            'payment_status' => 'Unpaid', // Initial payment status
        ]);
    
        $user = User::find($booking->UserID);
        $message = "Thank you for your booking, {$user->FirstName}. Your booking for {$service->Name} on {$booking->BookingDate} at {$booking->BookingTime} is confirmed.";
        $this->semaphoreService->sendSms($user->PhoneNumber, $message);
    
        return response()->json([
            'booking' => $booking,
        ], 201);
    }
    

    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $request->validate([
            "UserName" => "string",
            "ServiceType" => "string",
            "AddOns" => "nullable|array",
            "BookingDate" => "date",
            "BookingTime" => "nullable|date_format:H:i",
            "Location" => "string",
        ]);

        if ($request->has('UserName')) {
            $userNameParts = explode(' ', $request->UserName);
            $firstName = $userNameParts[0];
            $lastName = count($userNameParts) > 1 ? $userNameParts[1] : '';

            $user = User::where('FirstName', $firstName)->where('LastName', $lastName)->firstOrFail();
            $booking->UserID = $user->UserID;
        }

        if ($request->has('ServiceType')) {
            $service = Service::where('Name', $request->ServiceType)->firstOrFail();
            $booking->ServiceID = $service->ServiceID;
        }

        if ($request->has('AddOns')) {
            $price = $service->Price;
            foreach ($request->AddOns as $addOnName) {
                $addOn = Service::where('Name', $addOnName)->first();
                if ($addOn) {
                    $price += $addOn->Price;
                }
            }
            $booking->AddOns = json_encode($request->AddOns);
            $booking->Price = $price;
        }

        $booking->BookingDate = $request->BookingDate ?? $booking->BookingDate;
        $booking->BookingTime = $request->BookingTime ?? $booking->BookingTime;
        $booking->Location = $request->Location ?? $booking->Location;
        $booking->save();

        // Send SMS notification after booking is updated
        $user = User::find($booking->UserID);
        $message = "Dear {$user->FirstName}, your booking for {$service->Name} on {$booking->BookingDate} at {$booking->BookingTime} has been updated.";
        $this->semaphoreService->sendSms($user->PhoneNumber, $message);

        return response()->json([
            "booking" => $booking,
        ], 200);
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return response()->json([
            "message" => "Booking deleted",
        ], 200);
    }

    public function confirm(Request $request, $id)
    {
        try {
            $booking = Booking::findOrFail($id);
            $booking->Status = 'Confirmed';
            $booking->save();

            // Send SMS notification after booking is confirmed
            $user = User::find($booking->UserID);
            $message = "Dear {$user->FirstName}, your booking for {$booking->service->Name} on {$booking->BookingDate} at {$booking->BookingTime} has been confirmed.";
            $this->semaphoreService->sendSms($user->PhoneNumber, $message);

            return response()->json(['message' => 'Booking confirmed'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to confirm booking'], 500);
        }
    }

    public function initiatePayment($id)
    {
        Log::info("Initiate payment called for booking ID: {$id}");
        try {
            $booking = Booking::findOrFail($id);
            $amount = $booking->Price;
            $currency = 'PHP'; // Change as needed
    
            $response = $this->payPalService->createOrder(
                $amount,
                $currency,
                route('payment.callback', ['id' => $booking->BookingID]),
                route('payment.cancel', ['id' => $booking->BookingID])
            );
    
            if ($response && !empty($response->links)) {
                foreach ($response->links as $link) {
                    if ($link->rel == 'approve') {
                        Log::info("PayPal payment approval URL: {$link->href}");
                        return response()->json(['paymentUrl' => $link->href]);
                    }
                }
                Log::warning('No approval URL found in PayPal response', ['response' => $response]);
                return response()->json(['error' => 'No approval URL found in PayPal response'], 500);
            } else {
                Log::error('Failed to create PayPal order or response is invalid', ['response' => $response]);
                return response()->json(['error' => 'Failed to create PayPal order'], 500);
            }
        } catch (\Exception $e) {
            Log::error('Error initiating PayPal payment:', ['message' => $e->getMessage(), 'stack' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Failed to initiate PayPal payment'], 500);
        }
    }
    
    
    
    public function handlePaymentCallback(Request $request, $id)
    {
        Log::info('Payment callback called', ['method' => $request->getMethod(), 'id' => $id, 'query' => $request->query()]);
        try {
            $orderId = $request->query('token'); // Ensure you're fetching the correct query parameter
    
            $result = $this->payPalService->captureOrder($orderId);
    
            if ($result) {
                $booking = Booking::findOrFail($id);
                $booking->payment_status = 'Paid';
                $booking->save();
    
                return response()->json(['message' => 'Payment successful'], 200);
            } else {
                return response()->json(['error' => 'Payment failed'], 500);
            }
        } catch (\Exception $e) {
            Log::error('Error handling PayPal payment callback:', ['message' => $e->getMessage(), 'stack' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Failed to update payment status'], 500);
        }
    }
    
    public function handlePaymentCancel(Request $request, $id)
    {
        Log::info("Payment cancellation handled for booking ID: {$id}");
        \Log::info('Handling PayPal payment cancellation', ['booking_id' => $id]);
        return response()->json(['message' => 'Payment cancelled'], 200);
    }
    
}    