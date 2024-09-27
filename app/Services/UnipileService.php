<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class UnipileService
{
    protected $apiKey;
    protected $dsn;

    public function __construct()
    {
        $this->apiKey = config('services.unipile.api_key'); // Unipile API key
        $this->dsn = config('services.unipile.dsn'); // Unipile DSN URL
    }

    /**
     * Create a new link for hosted accounts.
     *
     * @param string $type
     * @param string $providers
     * @param string $expiresOn
     * @return array
     */
    public function createHostedAccountLink(string $type = 'create', string $providers = '*', string $expiresOn = '2024-12-22T12:00:00.701Z')
    {
        $response = Http::withHeaders([
            'X-API-KEY' => $this->apiKey,
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ])->post($this->dsn . '/api/v1/hosted/accounts/link', [
            'type' => $type,
            'providers' => $providers,
            'api_url' => $this->dsn, // This might not be necessary if passed in the URL
            'expiresOn' => $expiresOn,
            'notify_url' => config('services.unipile.notify_url')
        ]);

        return $response->json();
    }
}
