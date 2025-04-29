<?php

namespace Elite\StrowalletLaravel\Services;

use Elite\StrowalletLaravel\Http\Client;
use Illuminate\Support\Collection;

class WalletService
{
    public function __construct(protected Client $client) {}

    /**
     * Transfer funds from the authenticated user's wallet to another user.
     *
     * Required parameters:
     * - amount (string) - The amount to transfer (in the wallet's currency).
     * - currency (string) - The 3-letter currency code (e.g., USD, NGN).
     * - receiver (string) - The recipient's email or username or Phone on Strowallet.
     * - note (string) - Description for the transfer.
     *
     * @param string $amount Amount to transfer.
     * @param string $currency Currency code (e.g., USD, NGN).
     * @param string $receiver Receiver's email or username.
     * @param string $note transfer note.
     * @return Collection
     */
    public function transfer(
        string $amount,
        string $currency,
        string $receiver,
        string $note
    ): Collection {
        return $this->client->post('/users/transfer', [
            'amount' => $amount,
            'currency' => $currency,
            'receiver' => $receiver,
            'note' => $note,
        ]);
    }
}
