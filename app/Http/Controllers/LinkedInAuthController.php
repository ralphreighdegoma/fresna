<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LinkedInAuthService;

class LinkedInAuthController extends Controller
{
    protected $linkedInAuthService;

    public function __construct(LinkedInAuthService $linkedInAuthService)
    {
        $this->linkedInAuthService = $linkedInAuthService;
    }


    public function renderCaptcha(Request $request)
    {
        $checkpointData = $request->input('checkpoint');

        if ($checkpointData['type'] === 'CAPTCHA') {
            // Decode the CAPTCHA data here
            $decodedData = base64_decode($checkpointData['data']);

            // Render the CAPTCHA (this will depend on the library you're using)
            return response()->json([
                'public_key' => $checkpointData['public_key'],
                'captcha_data' => $decodedData, // Adjust as needed for your CAPTCHA implementation
            ]);
        }

        return response()->json(['message' => 'No CAPTCHA needed'], 400);
    }

    public function submitCaptchaResponse(Request $request, $accountId)
    {
        $request->validate([
            'captcha_response' => 'required|string', // the response from the CAPTCHA
        ]);

        $response = $this->linkedInAuthService->solveCaptcha($accountId, $request->input('captcha_response'));

        return response()->json($response);
    }


    public function authenticateWithCredentials(Request $request)
    {
        $request->validate([
            'username' => 'required|email',
            'password' => 'required|string',
        ]);

        $response = $this->linkedInAuthService->authenticateWithCredentials(
            $request->username,
            $request->password
        );

        return response()->json($response);
    }

    public function authenticateWithCookie(Request $request)
    {
        $request->validate([
            'access_token' => 'required|string',
            'user_agent' => 'required|string',
        ]);

        $response = $this->linkedInAuthService->authenticateWithCookie(
            $request->access_token,
            $request->user_agent
        );

        return response()->json($response);
    }

    public function handleCheckpoint(Request $request)
    {
        $request->validate([
            'account_id' => 'required|string',
            'code' => 'required|string',
        ]);

        $response = $this->linkedInAuthService->handleCheckpoint(
            $request->account_id,
            $request->code
        );

        return response()->json($response);
    }
}
