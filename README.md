# laravel-telegram-logger
Send Laravel log to Telegram Bot or Channel 

# Install

```bash
composer require thanhtaivtt/laravel-telegram-logger
```

# Config

- Add this code to the `config/logging.php`

```php
'telegram' => [
            'driver' => 'custom',
            'via' => \Thanhtaivtt\TelegramLogger\TelegramLogger::class,
            'api_key' => env('TELEGRAM_API_KEY'),
            'chat_id' => env('TELEGRAM_CHAT_ID'),
            'send_log' => env('TELEGRAM_SEND_LOG', false),
        ],
```
- And add `telegram` channel to current stack channel:

Eg:

```php
'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['daily', 'telegram'],
            'ignore_exceptions' => false,
        ],

```

- Define Telegram Bot Token and chat id on `.env`

```bash
TELEGRAM_API_KEY=617786012:AAGTlomrzNq4eQpt54VWEfqYW5Ud-EWp5x0
TELEGRAM_CHAT_ID=@tdc_logging
TELEGRAM_SEND_LOG=true
```

**Description**

| Key | Type | Description |
|----------|-------------|------|
| `TELEGRAM_API_KEY` | `String` | Token of Telegram Bot or Channel |
| `TELEGRAM_CHAT_ID` | `String` | Bot or Channel ID (Include the @ character) |
| `TELEGRAM_SEND_LOG` | `Boolean` | Specify whether to send the log or not |
 
If you want to send the log in all other than local environments, you can set it as follows:
 
```php
'telegram' => [
            'driver' => 'custom',
            'via' => \Thanhtaivtt\TelegramLogger\TelegramLogger::class,
            'api_key' => env('TELEGRAM_API_KEY'),
            'chat_id' => env('TELEGRAM_CHAT_ID'),
            'send_log' => env('APP_ENV') !== 'local',
        ],
```
