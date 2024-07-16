<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class SemaphoreService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('SEMAPHORE_API_KEY');
    }

    public function sendSms($number, $message)
    {
        try {
            // Ensure the phone number is in the correct format
            $number = $this->formatPhoneNumber($number);

            // Use the default sender name "SEMAPHORE"
            $senderName = 'SEMAPHORE';

            $response = $this->client->post('https://api.semaphore.co/api/v4/messages', [
                'form_params' => [
                    'apikey' => $this->apiKey,
                    'number' => $number,
                    'message' => $message,
                    'sendername' => $senderName
                ],
            ]);

            $responseBody = json_decode($response->getBody(), true);
            Log::info('Semaphore SMS Request:', [
                'apikey' => $this->apiKey,
                'number' => $number,
                'message' => $message,
                'sendername' => $senderName
            ]);
            Log::info('Semaphore SMS Response:', $responseBody);

            // Check if the response indicates a failure
            if (isset($responseBody[0]['status']) && $responseBody[0]['status'] == 'Failed') {
                Log::error('Semaphore SMS Error:', $responseBody);
            }

            return $responseBody;
        } catch (\Exception $e) {
            Log::error('Error sending SMS via Semaphore: ' . $e->getMessage());
            return false;
        }
    }

    private function formatPhoneNumber($phoneNumber)
    {
        // Remove all non-numeric characters
        $phoneNumber = preg_replace('/\D/', '', $phoneNumber);

        // Ensure it starts with the correct format for the Philippines (09XXXXXXXXX)
        if (substr($phoneNumber, 0, 2) == '63') {
            $phoneNumber = '0' . substr($phoneNumber, 2);
        } elseif (substr($phoneNumber, 0, 1) != '0') {
            $phoneNumber = '0' . $phoneNumber;
        }

        return $phoneNumber;
    }
}
