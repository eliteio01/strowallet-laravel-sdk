<?php

namespace Elite\StrowalletLaravel\Services;

use Elite\StrowalletLaravel\Exceptions\StrowalletException;
use Elite\StrowalletLaravel\Http\Client;
use Illuminate\Support\Collection;

class CardService
{
    public const CREATE_CARD_USER_FIELDS = [
        'houseNumber',
        'firstName',
        'lastName',
        'idNumber',
        'customerEmail',
        'phoneNumber',
        'dateOfBirth',
        'idImage',
        'userPhoto',
        'line1',
        'state',
        'zipCode',
        'city',
        'country',
        'idType',
    ];

    public function __construct(protected Client $client) {}

    /**
     * Create a new cardholder user.
     *
     * Required fields:
     * - houseNumber
     * - firstName
     * - lastName
     * - idNumber
     * - customerEmail
     * - phoneNumber
     * - dateOfBirth
     * - idImage
     * - userPhoto
     * - line1
     * - state
     * - zipCode
     * - city
     * - country
     * - idType
     *
     * @param array $userData
     * @return Collection
     * @throws StrowalletException
     */
    public function createCardUser(array $userData): Collection
    {
        foreach (self::CREATE_CARD_USER_FIELDS as $field) {
            if (empty($userData[$field])) {
                throw new StrowalletException(
                    "Missing required field: {$field}. Expected fields: " . implode(', ', self::CREATE_USER_FIELDS)
                );
            }
        }

        return $this->client->post('/bitvcard/create-user', $userData);
    }

    /**
     * Update an existing cardholder information.
     *
     * Required field:
     * - customerId (string)
     * 
     * Other updatable fields (optional):
     * - firstName
     * - lastName
     * - idImage
     * - userPhoto
     * - phoneNumber
     * - country
     * - city
     * - state
     * - zipCode
     * - line1
     * - houseNumber
     *
     * @param array $userData
     * @return Collection
     * @throws StrowalletException
     */
    public function updateCardHolder(array $userData): Collection
    {
        if (empty($userData['customerId'])) {
            throw new StrowalletException(
                "Missing required field: customerId. You must provide customerId to update a cardholder."
            );
        }

        return $this->client->put('/bitvcard/updateCardCustomer', $userData);
    }

    /**
     * Get details of a cardholder user.
     *
     * @param string $customerId
     * @param string $customerEmail
     * @return Collection
     */
    public function getCardHolder(string $customerId, string $customerEmail): Collection
    {
        return $this->client->get('/bitvcard/getcardholder/', [
            'customerId' => $customerId,
            'customerEmail' => $customerEmail,
        ]);
    }


    /**
     * Create a virtual card for a user.
     *
     * Required fields:
     * - name_on_card (string): Card holder's name (e.g., "My Name").
     * - card_type (string): Card type (e.g., "visa").
     * - amount (string): Prefund amount (e.g., "5").
     * - customerEmail (string): Email address of the cardholder (must be registered).
     *
     * Optional fields:
     * - mode (string): Pass "sandbox" for test cards (optional).
     * - developer_code (string): Provided by Strowallet (optional).
     *
     * @param array $cardData Card creation parameters.
     * @return Collection
     *
     * @throws StrowalletException If required fields are missing.
     */
    public function createCard(array $cardData): Collection
    {
        $requiredFields = [
            'name_on_card',
            'card_type',
            'amount',
            'customerEmail',
        ];

        foreach ($requiredFields as $field) {
            if (empty($cardData[$field])) {
                throw new StrowalletException("Missing required field: {$field}");
            }
        }

        return $this->client->post('/bitvcard/create-card', $cardData);
    }
    /**
     * Fund an existing virtual card.
     *
     * Required fields:
     * - card_id (string): The ID of the card to fund.
     * - amount (string): The amount to fund the card with.
     *
     * Optional fields:
     * - mode (string): Pass "sandbox" to fund a test card (optional).
     *
     * @param array $fundData Card funding parameters.
     * @return Collection
     *
     * @throws StrowalletException If required fields are missing.
     */
    public function fundCard(array $fundData): Collection
    {
        $requiredFields = [
            'card_id',
            'amount',
        ];

        foreach ($requiredFields as $field) {
            if (empty($fundData[$field])) {
                throw new StrowalletException("Missing required field: {$field}");
            }
        }

        return $this->client->post('/bitvcard/fund-card', $fundData);
    }

    /**
     * Retrieve details of a specific virtual card.
     *
     * Required fields:
     * - card_id (string): The ID of the card to fetch.
     *
     * Optional fields:
     * - mode (string): Pass "sandbox" to fetch sandbox card details.
     *
     * @param array $cardData
     * @return Collection
     *
     * @throws StrowalletException If required fields are missing.
     */
    public function getCardDetails(array $cardData): Collection
    {
        $requiredFields = ['card_id'];

        foreach ($requiredFields as $field) {
            if (empty($cardData[$field])) {
                throw new StrowalletException("Missing required field: {$field}");
            }
        }

        return $this->client->post('/bitvcard/fetch-card-detail', $cardData);
    }

    /**
     * Retrieve details of a specific virtual card.
     *
     * Required fields:
     * - card_id (string): The ID of the card to fetch.
     *
     * Optional fields:
     * - mode (string): Pass "sandbox" to fetch sandbox card details.
     *
     * @param array $cardData
     * @return Collection
     *
     * @throws StrowalletException If required fields are missing.
     */
    public function getCardTransactions(array $cardData): Collection
    {
        $requiredFields = ['card_id'];

        foreach ($requiredFields as $field) {
            if (empty($cardData[$field])) {
                throw new StrowalletException("Missing required field: {$field}");
            }
        }

        return $this->client->post('/bitvcard/card-transactions', $cardData);
    }

    /**
     * Freeze or unfreeze a virtual card.
     *
     * Required fields:
     * - action (string): Either "freeze" or "unfreeze".
     * - card_id (string): The ID of the card to act upon.
     *
     * @param array $cardData
     * @return Collection
     *
     * @throws StrowalletException If required fields are missing.
     */
    public function cardAction(array $cardData): Collection
    {
        $requiredFields = ['action', 'card_id'];

        foreach ($requiredFields as $field) {
            if (empty($cardData[$field])) {
                throw new StrowalletException("Missing required field: {$field}");
            }
        }

        return $this->client->post('/bitvcard/action/status', $cardData);
    }

    /**
     * Get transactions for a specific virtual card.
     *
     * Required fields:
     * - card_id (string): The ID of the card.
     * - page (string): The page number (default 1).
     * - take (string): Number of records per page (maximum 50).
     *
     * @param array $params
     * @return Collection
     *
     * @throws StrowalletException If required fields are missing.
     */
    public function getCardFullTransactions(array $params): Collection
    {
        $requiredFields = ['card_id', 'page', 'take'];

        foreach ($requiredFields as $field) {
            if (empty($params[$field])) {
                throw new StrowalletException("Missing required field: {$field}");
            }
        }

        return $this->client->get('/bitvcard/capicard-transactions', $params);
    }
    /**
     * Update the balance of a specific virtual card.
     *
     * Required fields:
     * - card_id (string): The ID of the card.
     * - amount (string): The amount to update the card balance by.
     *
     * @param array $params
     * @return Collection
     *
     * @throws StrowalletException If required fields are missing.
     */
    public function withdrawCard(array $params): Collection
    {
        $requiredFields = ['card_id', 'amount'];

        foreach ($requiredFields as $field) {
            if (empty($params[$field])) {
                throw new StrowalletException("Missing required field: {$field}");
            }
        }

        return $this->client->post('/bitvcard/card_withdraw', $params);
    }

    /**
     * Withdraw from a specific virtual card using a reference.
     *
     * Required fields:
     * - reference (string): The reference obtained from the card withdraw API.
     *
     * @param array $params
     * @return Collection
     *
     * @throws StrowalletException If required fields are missing.
     */
    public function cardWithdrawStatus(array $params): Collection
    {


        if (empty($params['reference'])) {
            throw new StrowalletException("Missing required field: reference");
        }

        return $this->client->get('/bitvcard/getcard_withdrawstatus', $params);
    }


    /**
     * Update card user details.
     *
     * Required fields:
     * - customerId (string): Customer's unique ID.
     * - cardUserId (string): Get this from the 'get card details' API.
     * - firstName (string): The first name of the cardholder.
     * - lastName (string): The last name of the cardholder.
     * - dateOfBirth (string): Date of birth in mm/dd/yyyy format.
     * - line1 (string): Address line 1.
     *
     * @param array $userData
     * @return Collection
     *
     * @throws StrowalletException If required fields are missing.
     */
    public function upgradeCardLimt(array $userData): Collection
    {
        $requiredFields = [
            'customerId',
            'cardUserId',
            'firstName',
            'lastName',
            'dateOfBirth',
            'line1',
        ];

        foreach ($requiredFields as $field) {
            if (empty($userData[$field])) {
                throw new StrowalletException("Missing required field: {$field}");
            }
        }

        return $this->client->put('/bitvcard/upgradecardlimit', $userData);
    }
    /**
     * Create or update a card with the provided details.
     *
     * Required fields:
     * - name_on_card (string): Name to be printed on the card.
     * - amount (string): Amount to be added or deducted.
     * - customerEmail (string): Customer's email address.
     * - mode (string): Environment mode (defaults to 'sandbox').
     * - developer_code (string): Provided by Strowallet (optional).
     *
     * @param array $cardData
     * @return Collection
     *
     * @throws StrowalletException If required fields are missing.
     */
    public function createGiftCard(array $cardData): Collection
    {
        $requiredFields = [
            'name_on_card',
            'amount',
            'customerEmail',
        ];

        foreach ($requiredFields as $field) {
            if (empty($cardData[$field])) {
                throw new StrowalletException("Missing required field: {$field}");
            }
        }

        // Set the default mode to 'sandbox' if not provided
        $cardData['mode'] = $cardData['mode'] ?? 'sandbox';

        return $this->client->post('/bitvcard/create-giftcard', $cardData);
    }
}
