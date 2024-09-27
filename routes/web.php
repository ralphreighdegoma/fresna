<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LinkedInAuthController;
use App\Http\Controllers\WhatsAppAuthController;
use App\Http\Controllers\UnipileController;


Route::post('/unipile/create-link', [UnipileController::class, 'createHostedAccountLink']);

Route::post('/whatsapp/auth/request-qrcode', [WhatsAppAuthController::class, 'requestQRCode']);
Route::get('/whatsapp/auth/status/{accountId}', [WhatsAppAuthController::class, 'checkAccountStatus']);


Route::post('/linkedin/auth/credentials', [LinkedInAuthController::class, 'authenticateWithCredentials']);
Route::post('/linkedin/auth/cookie', [LinkedInAuthController::class, 'authenticateWithCookie']);
Route::post('/linkedin/auth/checkpoint', [LinkedInAuthController::class, 'handleCheckpoint']);

Route::post('/linkedin/auth/captcha/render', [LinkedInAuthController::class, 'renderCaptcha']);
Route::post('/linkedin/auth/captcha/submit/{accountId}', [LinkedInAuthController::class, 'submitCaptchaResponse']);

Route::get('/', function () {
    return view('welcome');
});


//callback
Route::get('/callback/unipile', [UnipileController::class, 'handleCallback']);

