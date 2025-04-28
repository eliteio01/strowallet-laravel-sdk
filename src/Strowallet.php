<?php

namespace Elite\StrowalletLaravel;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;
use Elite\StrowalletLaravel\Exceptions\StrowalletException;
use Illuminate\Http\Client\RequestException;

class Strowallet
{
    protected string $baseUrl;
    protected string $apiKey;
    protected int $retryAttempts = 3;
    protected int $timeout = 10; // Timeout in seconds

    public function __construct()
    {
        $this->baseUrl = config('strowallet.base_url') ?? '';
        $this->apiKey = config('strowallet.api_key') ?? '';

        if (empty($this->apiKey)) {
            throw new \RuntimeException('Strowallet API key is not set. Please check your .env or config.');
        }

        if (empty($this->baseUrl)) {
            throw new \RuntimeException('Strowallet Base URL is not set. Please check your .env or config.');
        }
    }

    public function getBankList(): Collection
    {
        return $this->get('/banks/lists');
    }

    public function getBankName(string $bankCode, string $accountNumber): Collection
    {
        return $this->get('/banks/get-customer-name', [
            'bank_code' => $bankCode,
            'account_number' => $accountNumber,
        ]);
    }

    public function bankTransfer(string $amount, string $bankCode, string $accountNumber, string $narration, string $nameEnquiryRef, string $senderName = ''): Collection
    {
        return $this->post('/banks/request', [
            'amount' => $amount,
            'bank_code' => $bankCode,
            'account_number' => $accountNumber,
            'narration' => $narration,
            'name_enquiry_reference' => $nameEnquiryRef,
            'SenderName' => $senderName,
        ]);
    }

    public function walletTransfer(string $amount, string $currency, string $receiver, string $note): Collection
    {
        return $this->post('/users/transfer', [
            'amount' => $amount,
            'currency' => $currency,
            'receiver' => $receiver,
            'note' => $note,
        ]);
    }

    protected function get(string $endpoint, array $params = []): Collection
    {
        try {
            $params = $this->injectPublicKey($params);

            $response = Http::timeout($this->timeout)
                ->retry($this->retryAttempts, 100)
                ->get($this->baseUrl . $endpoint, $params);

            return $this->handleResponse($response);
        } catch (RequestException $e) {
            throw new StrowalletException('Failed to connect to Strowallet API: ' . $e->getMessage());
        }
    }

    protected function post(string $endpoint, array $payload): Collection
    {
        try {
            $payload = $this->injectPublicKey($payload);

            $response = Http::timeout($this->timeout)
                ->retry($this->retryAttempts, 100)
                ->post($this->baseUrl . $endpoint, $payload);

            return $this->handleResponse($response);
        } catch (RequestException $e) {
            throw new StrowalletException('Failed to connect to Strowallet API: ' . $e->getMessage());
        }
    }

    protected function injectPublicKey(array $data): array
    {
        return array_merge(['public_key' => $this->apiKey], $data);
    }

    protected function handleResponse($response): Collection
    {
        if ($response->successful()) {
            return collect($response->json());
        }

        $message = $response->json('message') ?? 'Unknown Strowallet API Error';
        $status = $response->status();

        throw new StrowalletException("Strowallet API Error ({$status}): {$message}");
    }
}
