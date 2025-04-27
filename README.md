
# 📦 Strowallet Laravel SDK

A simple, clean, and powerful Laravel package to easily interact with [Strowallet](https://strowallet.com) APIs.

---

## ✨ Features

- Easy integration with Strowallet API
- Configurable API keys and endpoints
- Ready to use with Laravel's Service Container
- Supports publishing configuration file
- Built on top of Laravel HTTP Client

---

## 📥 Installation

You can install the package via Composer:

```bash
composer require elite/strowallet-laravel
```

---

## ⚙️ Configuration

After installing, publish the configuration file:

```bash
php artisan vendor:publish --tag=config --provider="Elite\StrowalletLaravel\StrowalletServiceProvider"
```

This will create a `config/strowallet.php` file.

Set your `.env` variables:

```dotenv
STROWALLET_BASE_URL=https://strowallet.com/api
STROWALLET_API_KEY=your-api-key-here
```

---

## 🚀 Usage

Inject the `Strowallet` class into your services or controllers:

```php
use Elite\StrowalletLaravel\Strowallet;

class WalletController extends Controller
{
    public function balance(Strowallet $strowallet)
    {
        $balance = $strowallet->getWalletBalance();
        return response()->json($balance);
    }
}
```

Or if you have a Facade (optional):

```php
use Strowallet;

$balance = Strowallet::getWalletBalance();
```

---

## 📚 Available Methods

| Method                    | Description                            |
|----------------------------|----------------------------------------|
| `getWalletBalance()`       | Fetch the current wallet balance       |
| *(More methods coming soon)* | Extend the SDK as needed!              |

---

## 🛠️ Extending

You can easily extend the `Strowallet` class to add more API endpoints such as:

- Sending Money
- Viewing Transactions
- Creating Virtual Accounts
- Managing Cards
- etc.

Pull requests are welcome! 🎉

---

## 🧹 Testing

To run tests:

```bash
composer test
```

(Testing suite coming soon!)

---

## 📝 License

This package is open-sourced software licensed under the [MIT license](LICENSE).

---

# 🚀 Quick Start

```bash
composer require elite/strowallet-laravel
php artisan vendor:publish --tag=config
```

And you're ready to go! 🎯

---

# 📣 Contributing

Contributions, issues, and feature requests are very welcome!  
Feel free to open a pull request or submit an issue.

---

# 📬 Credits

- Developed by [Elite](https://github.com/eliteio01)  
- Strowallet API powered by [Strowallet](https://strowallet.com)
