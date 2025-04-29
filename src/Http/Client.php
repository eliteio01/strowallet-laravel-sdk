<?php

namespace Elite\StrowalletLaravel\Http;

use Elite\StrowalletLaravel\Exceptions\StrowalletException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;

class Client
{
    protected string $baseUrl;
    protected string $apiKey;
    protected int $retryAttempts = 3;
    protected int $timeout = 10;

    public function __construct(string $baseUrl, string $apiKey)
    {
        $this->baseUrl = $baseUrl;
        $this->apiKey = $apiKey;
    }

    public function get(string $endpoint, array $params = []): Collection
    {
        return $this->request('get', $endpoint, $params);
    }

    public function post(string $endpoint, array $payload = []): Collection
    {
        return $this->request('post', $endpoint, $payload);
    }

    public function put(string $endpoint, array $payload = []): Collection
    {
        return $this->request('put', $endpoint, $payload);
    }

    protected function request(string $method, string $endpoint, array $data = []): Collection
    {
        try {
            $data = $this->injectPublicKey($data);

            $response = Http::timeout($this->timeout)
                ->retry($this->retryAttempts, 100)
                ->{$method}($this->baseUrl . $endpoint, $data);

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