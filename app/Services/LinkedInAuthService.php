<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class LinkedInAuthService
{
    protected $apiKey;
    protected $dsn;

    public function __construct()
    {
        $this->apiKey = config('services.unipile.api_key'); // Unipile API key
        $this->dsn = config('services.unipile.dsn'); // Your Unipile DSN
    }


    public function solveCaptcha(string $accountId, string $captchaResponse)
    {
        $response = Http::withHeaders([
            'X-API-KEY' => $this->apiKey,
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ])->post($this->dsn . '/api/v1/accounts/checkpoint', [
            'provider' => 'WHATSAPP',
            'account_id' => $accountId,
            'captcha_response' => $captchaResponse, // response from the CAPTCHA
        ]);

        return $response->json();
    }


    

    /**
     * Authenticate with LinkedIn using Username/Password
     */
    public function authenticateWithCredentials(string $username, string $password)
    {
        $response = Http::withHeaders([
            'X-API-KEY' => $this->apiKey,
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ])->post($this->dsn . '/api/v1/accounts', [
            'provider' => 'LINKEDIN',
            'username' => $username,
            'password' => $password,
        ]);

        return $response->json();
    }

    /**
     * Authenticate with LinkedIn using Cookies (access token and user agent)
     */
    public function authenticateWithCookie(string $accessToken, string $userAgent)
    {
        $response = Http::withHeaders([
            'X-API-KEY' => $this->apiKey,
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ])->post($this->dsn . '/api/v1/accounts', [
            'provider' => 'LINKEDIN',
            'access_token' => $accessToken,
            'user_agent' => $userAgent,
        ]);

        return $response->json();
    }

    /**
     * Handle LinkedIn checkpoints (e.g. 2FA, OTP)
     */
    public function handleCheckpoint(string $accountId, string $checkpointCode)
    {
        $response = Http::withHeaders([
            'X-API-KEY' => $this->apiKey,
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ])->post($this->dsn . '/api/v1/accounts/checkpoint', [
            'provider' => 'LINKEDIN',
            'account_id' => $accountId,
            'code' => $checkpointCode,
        ]);

        return $response->json();
    }
}
