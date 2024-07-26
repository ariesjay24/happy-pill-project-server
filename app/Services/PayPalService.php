<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class PayPalService
{
    private $client;
    private $clientId;
    private $clientSecret;
    private $baseUrl;

    public function __construct()
    {
        $this->clientId = env('PAYPAL_CLIENT_ID');
        $this->clientSecret = env('PAYPAL_SECRET');
        $this->baseUrl = env('PAYPAL_MODE') === 'live'
            ? 'https://api.paypal.com'
            : 'https://api.sandbox.paypal.com';
        $this->client = new Client();
    }

    private function getAccessToken()
    {
        $response = $this->client->request('POST', $this->baseUrl . '/v1/oauth2/token', [
            'auth' => [$this->clientId, $this->clientSecret],
            'form_params' => [
                'grant_type' => 'client_credentials',
            ],
        ]);

        $data = json_decode($response->getBody());
        return $data->access_token;
    }

    public function createOrder($amount, $currency, $successUrl, $cancelUrl)
    {
        $accessToken = $this->getAccessToken();
    
        $response = $this->client->request('POST', $this->baseUrl . '/v2/checkout/orders', [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'intent' => 'CAPTURE',
                'purchase_units' => [
                    [
                        'amount' => [
                            'currency_code' => $currency,
                            'value' => $amount,
                        ],
                    ],
                ],
                'application_context' => [
                    'return_url' => $successUrl,
                    'cancel_url' => $cancelUrl,
                ],
            ],
        ]);
    
        $data = json_decode($response->getBody());
    
        Log::info('PayPal order created successfully', ['response' => $data]);
        return $data;
    }
    

    public function captureOrder($orderId)
    {
        try {
            $accessToken = $this->getAccessToken();

            $response = $this->client->request('POST', $this->baseUrl . '/v2/checkout/orders/' . $orderId . '/capture', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'application/json',
                ],
            ]);

            $data = json_decode($response->getBody());

            if (isset($data->id)) {
                Log::info('PayPal order captured successfully', ['order' => $data]);
                return $data;
            }

            throw new \Exception('Error capturing PayPal order');

        } catch (\Exception $e) {
            Log::error('Error capturing PayPal order:', ['message' => $e->getMessage()]);
            throw $e;
        }
    }
}