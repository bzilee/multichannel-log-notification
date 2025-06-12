# Multichannel Log Notification for Laravel

A Laravel package for sending log notifications via multiple channels (Telegram, HTTP, SMS, Email) with modular configuration and queue support.

## Installation

1. Install the package via Composer:
   ```bash
   composer require your-vendor/multichannel-log-notification
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
LOG_DEFAULT_CHANNELS=email
QUEUE_CONNECTION=database

TELEGRAM_LOGGER_BOT_TOKEN=your_bot_token
TELEGRAM_LOGGER_CHAT_ID=your_chat_id
LOG_TELEGRAM_ENABLED=true

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
        'handler' => \YourVendor\MultichannelLog\Logging\MultichannelLogHandler::class,
        'with' => [
            'level' => 'debug',
        ],
    ],
]
```

### Queue Support

The package supports queuing notifications for performance with large log volumes. Configure your queue in `config/queue.php` and set `QUEUE_CONNECTION` in `.env`. Run the queue worker:

```bash
php artisan queue:work --queue=multichannel-logs
```

### Channels by Log Level

Configure channels for specific log levels in `config/multichannel_log.php`:

```php
'channels_by_level' => [
    'emergency' => ['telegram', 'email', 'sms'],
    'alert' => ['telegram', 'email', 'sms'],
    'critical' => ['telegram', 'email', 'sms'],
    'error' => ['telegram', 'email'],
    'warning' => ['telegram', 'email'],
    'notice' => ['email'],
    'info' => ['email'],
    'debug' => ['email'],
],
```

## Usage

### Via Log Facade
Send logs using the Laravel Log facade:

```php
use Illuminate\Support\Facades\Log;

Log::channel('multichannel')->info('Test multichannel log', ['context' => 'Some context']);
Log::channel('multichannel')->error('Error log test');
```

### Via LogManager Facade
Send logs using the package's facade:

```php
use YourVendor\MultichannelLog\Facades\LogManager;

LogManager::send('Test log message');
LogManager::send('Urgent log message', ['telegram', 'email']);
```

## Requirements

- PHP ^8.0
- Laravel ^9.0|^10.0|^11.0
- laravel/vonage-notification-channel
- guzzlehttp/guzzle
- laravel-notification-channels/telegram
- monolog/monolog

## License

MIT