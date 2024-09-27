<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UnipileService;

class UnipileController extends Controller
{
    protected $unipileService;

    public function __construct(UnipileService $unipileService)
    {
        $this->unipileService = $unipileService;
    }

    /**
     * Handle the request to create a hosted account link.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createHostedAccountLink(Request $request)
    {
        $type = $request->input('type', 'create');
        $providers = $request->input('providers', '*');
        $expiresOn = $request->input('expiresOn', '2024-12-22T12:00:00.701Z');

        $response = $this->unipileService->createHostedAccountLink($type, $providers, $expiresOn);

        return response()->json($response);
    }

    /**
     * Handle the request to create a hosted account link.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleCallback(Request $request)
    {
        $response = $request->all();

        //save to accounts
        $account = new \App\Models\Account();
        $account->channel = 'WhatsApp';
        $account->name = $response['name'];
        $account->access_token = $response['account_id'];
        $account->save();

        return response()->json($response);
    }
}
