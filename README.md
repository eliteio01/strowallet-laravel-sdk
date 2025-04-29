# Strowallet Laravel SDK

[![Packagist Version](https://img.shields.io/packagist/v/elite/strowallet-sdk)](https://packagist.org/packages/elite/strowallet-laravel)
[![Packagist License](https://img.shields.io/packagist/l/elite/strowallet-sdk)](https://github.com/eliteio01/strowallet-laravel-sdk/blob/main/LICENSE)
[![License: MIT](https://img.shields.io/badge/license-MIT-purple.svg)](https://opensource.org/licenses/MIT)
[![GitHub Issues](https://img.shields.io/github/issues/eliteio01/strowallet-laravel-sdk)](https://github.com/eliteio01/strowallet-laravel-sdk/issues)

A clean and developer-friendly Laravel SDK for interacting with [Strowallet](https://strowallet.com), supporting virtual cards, wallet transfers, and bank transactions with ease.

---

## 📚 Table of Contents

- [✨ Features](#-features)  
- [📦 Installation](#-installation)  
- [⚙️ Configuration](#-configuration)  
- [🚀 Usage](#-usage)  
  - [Card Service](#card-service)  
  - [Wallet Service](#wallet-service)  
  - [Bank Service](#bank-service)  
- [💡 Examples](#-examples)  
- [🧹 Extending](#-extending)  
- [🧪 Testing](#-testing)  
- [📄 License](#-license)  
- [🤝 Contributing](#-contributing)  
- [🙌 Credits](#-credits)

---

## ✨ Features

- 🔐 Virtual card issuance and management  
- 💸 Wallet-to-wallet transfers  
- 🏦 Bank verification and transfers  
- ⚙️ Simple Laravel service-based architecture  
- ✅ Built-in request validation and error handling  
- 📘 Clean, readable, and extendable codebase

---

## 📦 Installation

Install via Composer:

```bash
composer require elite/strowallet-sdk
```

---

## ⚙️ Configuration

Add the following to your `.env` file:

```dotenv
STROWALLET_BASE_URL=https://strowallet.com/api
STROWALLET_API_KEY=your_pub_key_here
```

---

## 🚀 Usage

You can access services in two ways:

### ✅ Via Facade (Recommended)

```php
use Elite\StrowalletLaravel\Facades\Strowallet as StrowalletFacade;

// Get list of banks
$banks = StrowalletFacade::bank()->getBankList();

// Perform bank transfer
$response = StrowalletFacade::bank()->bankTransfer(
    amount: '50000',
    bankCode: '058',
    accountNumber: '0123456789',
    narration: 'Transfer for invoice',
    nameEnquiryRef: 'ref123456',
    senderName: 'Elite Corp'
);
```

### ✅ Via Dependency Injection

```php

use Elite\StrowalletLaravel\Strowallet;

class WalletController extends Controller
{
    public function showBalance(Strowallet $strowallet)
    {
        $balance = $strowallet->wallet()->getWalletBalance();
        return response()->json($balance);
    }
}

```

### Card Service

```php
$strowallet->card()->createCardUser([
    'firstName' => 'John',
    'lastName' => 'Doe',
    // ... additional fields
]);

$strowallet->card()->createCard([
    'name_on_card' => 'John Doe',
    'card_type' => 'visa',
    'amount' => '100.00',
    'customerEmail' => 'john@example.com'
]);
```

#### Available Card Methods

- `createCardUser(array $data)`
- `updateCardHolder(array $data)`
- `getCardHolder(string $customerEmail)`
- `createCard(array $data)`
- `fundCard(array $data)`
- `getCardDetails(string $cardId)`
- `cardAction(string $cardId, string $action)` — *freeze/unfreeze*
- `withdrawCard(array $data)`
- `getCardTransactions(string $cardId)`
- `createGiftCard(array $data)`

---

### Wallet Service

```php
$strowallet->wallet()->transfer(
    amount: '100.00',
    currency: 'USD',
    receiver: 'recipient@example.com',
    note: 'Payment for services'
);
```

---

### Bank Service

```php
// Fetch list of supported banks
$banks = $strowallet->bank()->getBankList();

// Verify bank account
$account = $strowallet->bank()->getBankName(
    bankCode: '000013',
    accountNumber: '0123456789'
);

// Initiate transfer
$transfer = $strowallet->bank()->bankTransfer(
    amount: '5000.00',
    bankCode: '058',
    accountNumber: '0123456789',
    narration: 'Salary payment',
    nameEnquiryRef: 'REF123456'
);
```

---

## 💡 Examples

### Full Virtual Card Flow

```php
// Step 1: Create user
$user = $strowallet->card()->createCardUser([
    'firstName' => 'John',
    'lastName' => 'Doe',
    // required fields...
]);

// Step 2: Create virtual card
$card = $strowallet->card()->createCard([
    'name_on_card' => 'John Doe',
    'card_type' => 'visa',
    'amount' => '100.00',
    'customerEmail' => 'john@example.com'
]);

// Step 3: Fund card
$fund = $strowallet->card()->fundCard([
    'card_id' => $card['id'],
    'amount' => '50.00'
]);
```

---

## 🧹 Extending

You can easily add custom methods to the SDK:

```php
public function newMethod(array $data): Collection
{
    return $this->client->post('/new-endpoint', $data);
}
```

Just define your method in the appropriate service class (`CardService`, `WalletService`, etc.).

---

## 🧪 Testing

Coming soon. The test suite will be available to ensure SDK stability and easy contribution.

In the meantime, you can run:

```bash
composer test
```

---

## 📄 License

This package is open-source software licensed under the [MIT license](LICENSE).

---

## 🤝 Contributing

We welcome all contributions!  
Please read our [CONTRIBUTING.md](CONTRIBUTING.md) for guidelines on submitting issues, feature requests, and pull requests.

---

## 🙌 Credits

- Developed by [Elite](https://github.com/eliteio01)  
- Powered by [Strowallet](https://strowallet.com)

