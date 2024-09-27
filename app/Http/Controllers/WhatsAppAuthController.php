<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WhatsAppAuthService;
use Chillerlan\QRCode\QRCode;

class WhatsAppAuthController extends Controller
{
    protected $whatsAppAuthService;

    public function __construct(WhatsAppAuthService $whatsAppAuthService)
    {
        $this->whatsAppAuthService = $whatsAppAuthService;
    }

    /**
     * Request a QR code for WhatsApp authentication
     */
    public function requestQRCode()
    {
        $response = $this->whatsAppAuthService->requestQRCode();
        return response()->json($response);
    }

    /**
     * Check the account status
     */
    public function checkAccountStatus($accountId)
    {
        $response = $this->whatsAppAuthService->checkAccountStatus($accountId);
        return response()->json($response);
    }

    public function displayQRCode(Request $request)
    {
        // Assume you have received the QR code data from the request
        $qrCodeData = $request->input('qr_code_data');

        // Generate the QR code
        $qrcode = new QRCode();
        $image = $qrcode->render($qrCodeData);

        return response($image)->header('Content-Type', 'image/png');
    }
}
