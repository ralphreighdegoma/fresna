<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WhatsAppAuthService
{
    protected $apiKey;
    protected $dsn;

    public function __construct()
    {
        $this->apiKey = config('services.unipile.api_key'); // Unipile API key
        $this->dsn = config('services.unipile.dsn'); // Your Unipile DSN
    }

    /**
     * Request a QR code for WhatsApp authentication
     */
    public function requestQRCode()
    {
        $response = Http::withHeaders([
            'X-API-KEY' => $this->apiKey,
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ])->post($this->dsn . '/api/v1/accounts', [
            'provider' => 'WHATSAPP',
        ]);

        return $response->json();
    }

    /**
     * Check the account status
     */
    public function checkAccountStatus(string $accountId)
    {
        $response = Http::withHeaders([
            'X-API-KEY' => $this->apiKey,
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ])->get($this->dsn . '/api/v1/accounts/' . $accountId);

        return $response->json();
    }
}
