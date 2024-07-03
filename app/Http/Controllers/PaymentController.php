<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Booking;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    private $gcashUrl = 'https://api.gcash.com'; // GCash API URL
    private $clientId = 'your_gcash_client_id';
    private $clientSecret = 'your_gcash_client_secret';

    public function initiatePayment(Request $request)
    {
        $bookingId = $request->input('booking_id');
        $amount = $request->input('amount');

        $booking = Booking::find($bookingId);
        if (!$booking) {
            return response()->json(['error' => 'Booking not found'], 404);
        }

        $client = new Client();

        try {
            $response = $client->post($this->gcashUrl . '/payment/initiate', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->getAccessToken(),
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'amount' => $amount,
                    'currency' => 'PHP',
                    'description' => 'Booking payment for ' . $booking->id,
                    'callback_url' => url('/api/payment/confirm'),
                ],
            ]);

            $responseData = json_decode($response->getBody(), true);

            return response()->json($responseData, 200);
        } catch (\Exception $e) {
            Log::error('Error initiating payment: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to initiate payment'], 500);
        }
    }

    public function confirmPayment(Request $request)
    {
        $transactionId = $request->input('transaction_id');
        $bookingId = $request->input('booking_id');
        $status = $request->input('status');

        $booking = Booking::find($bookingId);
        if (!$booking) {
            return response()->json(['error' => 'Booking not found'], 404);
        }

        $booking->payment_status = $status == 'success' ? 'Paid' : 'Failed';
        $booking->save();

        return response()->json(['message' => 'Payment status updated'], 200);
    }

    private function getAccessToken()
    {
        $client = new Client();

        $response = $client->post($this->gcashUrl . '/oauth/token', [
            'form_params' => [
                'grant_type' => 'client_credentials',
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
            ],
        ]);

        $data = json_decode($response->getBody(), true);
        return $data['access_token'];
    }
}
