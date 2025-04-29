<?php

namespace Elite\StrowalletLaravel;

use Elite\StrowalletLaravel\Http\Client;
use Elite\StrowalletLaravel\Services\BankService;
use Elite\StrowalletLaravel\Services\CardService;
use Elite\StrowalletLaravel\Services\WalletService;

class Strowallet
{
    protected Client $client;
    protected BankService $bank;
    protected WalletService $wallet;
    protected CardService $card;

    public function __construct()
    {
        $baseUrl = config('strowallet.base_url') ?? '';
        $apiKey = config('strowallet.api_key') ?? '';

        if (empty($apiKey)) {
            throw new \RuntimeException('Strowallet API key is not set. Please check your .env or config.');
        }

        if (empty($baseUrl)) {
            throw new \RuntimeException('Strowallet Base URL is not set. Please check your .env or config.');
        }

        $this->client = new Client($baseUrl, $apiKey);
        $this->bank = new BankService($this->client);
        $this->wallet = new WalletService($this->client);
        $this->card = new CardService($this->client);
    }

    public function bank(): BankService
    {
        return $this->bank;
    }

    public function wallet(): WalletService
    {
        return $this->wallet;
    }

    public function card(): CardService
    {
        return $this->card;
    }
}