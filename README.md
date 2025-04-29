# Strowallet SDK

[![Packagist Version](https://img.shields.io/packagist/v/elite/strowallet-laravel)](https://packagist.org/packages/elite/strowallet-laravel)
[![Packagist License](https://img.shields.io/packagist/l/elite/strowallet-laravel)](https://github.com/eliteio01/strowallet-laravel-sdk/blob/main/LICENSE)
[![License: MIT](https://img.shields.io/badge/license-MIT-purple.svg)](https://opensource.org/licenses/MIT)
[![GitHub Issues](https://img.shields.io/github/issues/eliteio01/strowallet-laravel-sdk)](https://github.com/eliteio01/strowallet-laravel-sdk/issues)


A comprehensive Laravel package for integrating with Strowallet's payment services including virtual cards, wallet transfers, and bank operations.


---

## Table of Contents
- [Features](#features)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
  - [Card Service](#card-service)
  - [Wallet Service](#wallet-service)
  - [Bank Service](#bank-service)
- [Examples](#examples)
- [Extending](#extending)
- [Testing](#testing)
- [License](#license)
- [Credits](#credits)


---


## Features
- Complete virtual card management
- Wallet-to-wallet transfers
- Bank account verification and transfers
- Easy Laravel integration
- Comprehensive error handling
- Well-documented methods


---

## Installation

Install via Composer:

```php
composer require elite/strowallet-sdk

```


Configure your `.env`:

```dotenv
STROWALLET_BASE_URL=https://strowallet.com/api
STROWALLET_API_KEY=your_api_key_here
```

## Usage

### Card Service

```php
$strowallet->card()->createCardUser([
    'firstName' => 'John',
    'lastName' => 'Doe',
    // ... all required fields
]);

$strowallet->card()->createCard([
    'name_on_card' => 'John Doe',
    'card_type' => 'visa',
    'amount' => '100.00',
    'customerEmail' => 'john@example.com'
]);
```

Available Card Methods:
- `createCardUser()` - Register new cardholder
- `updateCardHolder()` - Update cardholder details
- `getCardHolder()` - Get cardholder info
- `createCard()` - Issue virtual card
- `fundCard()` - Add funds to card
- `getCardDetails()` - View card details
- `cardAction()` - Freeze/unfreeze card
- `withdrawCard()` - Withdraw from card
- `getCardTransactions()` - View transactions
- `createGiftCard()` - Create gift card

### Wallet Service

```php
$strowallet->wallet()->transfer(
    amount: '100.00',
    currency: 'NGN',
    receiver: 'recipient@example.com',
    note: 'Payment for services'
);
```

### Bank Service

```php
// Get bank list
$banks = $strowallet->bank()->getBankList();

// Verify account
$account = $strowallet->bank()->getBankName(
    bankCode: '000013', // GTB
    accountNumber: '0123456789'
);

// Transfer funds
$transfer = $strowallet->bank()->bankTransfer(
    amount: '5000.00',
    bankCode: '058',
    accountNumber: '0123456789',
    narration: 'Salary payment',
    nameEnquiryRef: 'REF123456'
);
```

## Examples

### Complete Card Creation Flow

```php
// 1. Create card user
$user = $strowallet->card()->createCardUser([
    'firstName' => 'John',
    'lastName' => 'Doe',
    // ... all required fields
]);

// 2. Create virtual card
$card = $strowallet->card()->createCard([
    'name_on_card' => 'John Doe',
    'card_type' => 'visa',
    'amount' => '100.00',
    'customerEmail' => 'john@example.com'
]);

// 3. Fund the card
$fund = $strowallet->card()->fundCard([
    'card_id' => $card['id'],
    'amount' => '50.00'
]);
```
---

## Extending

To add new functionality:

1. Create a new method in the appropriate service class
2. Use the HTTP client to make requests:

```php
public function newMethod(array $data): Collection
{
    return $this->client->post('/new-endpoint', $data);
}
```
---

## Testing

Run the test suite:

```bash
composer test
```
(Testing suite coming soon!)

---

## License

This package is open-source software licensed under the [MIT license](LICENSE).

## 📣 Contributing

Contributions, issues, and feature requests are very welcome!  
Feel free to open a pull request or submit an issue.

## 📬 Credits

- Developed by [Elite](https://github.com/eliteio01)
- Strowallet API by [Strowallet](https://strowallet.com)
```

---

This README includes:

1. All the services and methods from your implementation
2. Clear usage examples
3. Proper badge links
4. Table of contents for easy navigation
5. Complete installation and configuration instructions
6. Practical code examples
7. Extension guidelines
8. License and contribution information


---

The formatting follows standard Markdown syntax and includes all the necessary sections for a comprehensive package documentation.