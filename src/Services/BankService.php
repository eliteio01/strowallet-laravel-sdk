<?php

namespace Elite\StrowalletLaravel\Services;

use Elite\StrowalletLaravel\Http\Client;
use Illuminate\Support\Collection;

class BankService
{
    public function __construct(protected Client $client) {}

    /**
     * Get the list of available banks.
     *
     * @return Collection
     */
    public function getBankList(): Collection
    {
        return $this->client->get('/banks/lists');
    }

    /**
     * Retrieve account holder name using bank code and account number.
     *
     * @param string $bankCode The code of the bank (e.g., 058 for GTBank).
     * @param string $accountNumber The user's account number.
     * @return Collection
     */
    public function getBankName(string $bankCode, string $accountNumber): Collection
    {
        return $this->client->get('/banks/get-customer-name', [
            'bank_code' => $bankCode,
            'account_number' => $accountNumber,
        ]);
    }

    /**
     * Perform a bank transfer to a specified account.
     *
     * Required parameters:
     * - amount (string)
     * - bankCode (string)
     * - accountNumber (string)
     * - narration (string)
     * - nameEnquiryRef (string)
     * 
     * Optional:
     * - senderName (string)
     *
     * @param string $amount Amount to transfer (in minor units if required, e.g., kobo).
     * @param string $bankCode Destination bank code.
     * @param string $accountNumber Destination account number.
     * @param string $narration Narration for the transfer.
     * @param string $nameEnquiryRef Name enquiry reference obtained during account verification.
     * @param string $senderName Sender name (optional).
     * @return Collection
     */
    public function bankTransfer(
        string $amount,
        string $bankCode,
        string $accountNumber,
        string $narration,
        string $nameEnquiryRef,
        string $senderName = ''
    ): Collection {
        return $this->client->post('/banks/request', [
            'amount' => $amount,
            'bank_code' => $bankCode,
            'account_number' => $accountNumber,
            'narration' => $narration,
            'name_enquiry_reference' => $nameEnquiryRef,
            'SenderName' => $senderName, 
        ]);
    }
}
