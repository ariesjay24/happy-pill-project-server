<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    private $magpieUrl = 'https://developer.magpie.im/v2'; // Magpie API URL

    public function createPaymentSource(Request $request)
    {
        // Log the entire request data
        Log::info('Incoming request data:', $request->all());

        // Validate the request data
        $request->validate([
            'type' => 'required|string',
            'amount' => 'required|integer|min:1',
            'currency' => 'required|string',
            'description' => 'required|string',
            'statement_descriptor' => 'required|string|max:15', // Ensure it fits the character limit
            'owner.email' => 'required|string|email',
            'owner.name' => 'required|string',
        ]);

        // Construct the payload
        $payload = [
            'type' => $request->input('type', 'paymaya'),
            'amount' => $request->input('amount'),
            'currency' => $request->input('currency', 'PHP'),
            'description' => $request->input('description', 'Booking Payment'),
            'statement_descriptor' => $request->input('statement_descriptor', 'HPPill'),
            'owner' => [
                'email' => $request->input('owner.email'),
                'name' => $request->input('owner.name'),
            ],
            'redirect' => [
                'success' => env('PAYMENT_SUCCESS_URL'),
                'failed' => env('PAYMENT_FAILED_URL'),
            ]
        ];

        Log::info('Creating payment source with payload:', $payload);

        try {
            $response = Http::withBasicAuth(env('MAGPIE_SECRET_KEY'), '')
                ->post($this->magpieUrl . '/sources', $payload);

            Log::info('Magpie API Response', ['response' => $response->body()]);

            if ($response->successful()) {
                return response()->json(['source' => $response->json()], 201);
            } else {
                Log::error('Failed to create payment source', ['response' => $response->body(), 'request' => $payload]);
                return response()->json([
                    'error' => 'Failed to create payment source',
                    'details' => $response->body(),
                    'request' => $payload
                ], $response->status());
            }
        } catch (\Exception $e) {
            Log::error('Exception while creating payment source', ['message' => $e->getMessage(), 'request' => $payload]);
            return response()->json([
                'error' => 'RequestException',
                'details' => $e->getMessage(),
                'request' => $payload
            ], 500);
        }
    }
}
