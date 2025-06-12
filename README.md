# Multichannel Log Notification for Laravel

A Laravel package for sending log notifications via multiple channels (Telegram, HTTP, SMS, Email) with modular configuration and queue support.

## Installation

1. Install the package via Composer:
   ```bash
   composer require bzilee/multichannel-log-notification
   ```

2. Publish the configuration file:
   ```bash
   php artisan vendor:publish --tag=config
   ```

3. Configure the channels in `config/multichannel_log.php` and add the necessary environment variables in `.env`.

## Configuration

Edit your `.env` file to enable and configure the desired channels:

```env
LOG_CHANNEL=stack
LOG_DEFAULT_CHANNELS=telegram,email
QUEUE_CONNECTION=redis

LOG_TELEGRAM_ENABLED=true
TELEGRAM_BOT_TOKEN=your_bot_token
TELEGRAM_CHAT_ID=your_chat_id

LOG_EMAIL_ENABLED=true
LOG_EMAIL_TO=logs@example.com
```

Add the `multichannel` channel to `config/logging.php`:

```php
'channels' => [
    'stack' => [
        'driver' => 'stack',
        'channels' => ['single', 'multichannel'],
        'ignore_exceptions' => false,
    ],
    'multichannel' => [
        'driver' => 'monolog',
        'handler' => \Bzilee\MultichannelLog\Logging\MultichannelLogHandler::class,
        'with' => [
            'level' => 'debug',
        ],
    ],
]
```

### Queue Support
Notifications are queued for performance. Configure `QUEUE_CONNECTION` in `.env` and run:
```bash
php artisan queue:work --queue=multichannel-logs
```

### Channels by Log Level
Configure channels per log level in `config/multichannel_log.php`:
```php
'channels_by_level' => [
    'emergency' => ['telegram', 'email', 'sms'],
    'error' => ['telegram', 'email'],
    'info' => ['email'],
    'debug' => ['email'],
],
```

## Usage
### Via Log Facade
```php
use Illuminate\Support\Facades\Log;

Log::channel('multichannel')->info('Test multichannel log', ['context' => 'Some context']);
```

### Via LogManager Facade
```php
use Bzilee\MultichannelLog\Facades\LogManager;

LogManager::send('Test log message', ['telegram', 'email']);
```

## Deployment
1. Publish to Packagist: Push to GitHub and submit to Packagist.
2. Install: `composer require bzilee/multichannel-log-notification`.
3. Configure `.env` and queue.
4. Deploy with a queue worker (e.g., Supervisor).

## Requirements
- PHP ^8.0
- Laravel ^11.0
- laravel/vonage-notification-channel
- guzzlehttp/guzzle
- monolog/monolog

## License
MIT