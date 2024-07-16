<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;

class BookingController extends Controller
{
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
            'AddOns' => json_encode($addOns->pluck('Name')->toArray()), // Ensure AddOns are saved as JSON
            'Price' => $totalPrice,
            'Status' => 'Pending',
            'payment_status' => 'Unpaid', // Initial payment status
        ]);

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
                $addOn = AddOn::where('Name', $addOnName)->first();
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

            return response()->json(['message' => 'Booking confirmed'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to confirm booking'], 500);
        }
    }

    public function initiatePayment($id)
    {
        try {
            $booking = Booking::findOrFail($id);
            $amount = $booking->Price * 100; // Convert to cents

            $client = new Client();
            $response = $client->post('https://api.paymongo.com/v1/sources', [
                'auth' => [env('PAYMONGO_SECRET_KEY'), ''],
                'json' => [
                    'data' => [
                        'attributes' => [
                            'amount' => $amount,
                            'redirect' => [
                                'success' => env('PAYMENT_SUCCESS_URL'),
                                'failed' => env('PAYMENT_FAILED_URL'),
                            ],
                            'type' => 'gcash',
                            'currency' => 'PHP',
                        ],
                    ],
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if (isset($data['data']['attributes']['redirect']['checkout_url'])) {
                return response()->json(['paymentUrl' => $data['data']['attributes']['redirect']['checkout_url']]);
            } else {
                return response()->json(['error' => 'Failed to initiate payment'], 500);
            }
        } catch (\Exception $e) {
            Log::error('Error initiating payment:', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to initiate payment'], 500);
        }
    }

    public function handlePaymentCallback(Request $request)
    {
        try {
            // Assuming the payment provider sends a booking ID and status
            $bookingId = $request->input('bookingId');
            $paymentStatus = $request->input('status');

            $booking = Booking::findOrFail($bookingId);
            $booking->payment_status = $paymentStatus;
            $booking->save();

            return response()->json(['message' => 'Payment status updated'], 200);
        } catch (\Exception $e) {
            Log::error('Error handling payment callback:', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to update payment status'], 500);
        }
    }
}
