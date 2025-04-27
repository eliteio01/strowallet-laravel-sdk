<?php

namespace Elite\StrowalletLaravel;

use Illuminate\Support\Facades\Http;

class Strowallet
{
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('strowallet.base_url');
        $this->apiKey = config('strowallet.api_key');
    }

    public function getWalletBalance()
    {
        $response = Http::withToken($this->apiKey)
                        ->get("{$this->baseUrl}/wallet/balance");

        return $response->json();
    }

}
