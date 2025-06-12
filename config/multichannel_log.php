<?php

return [
    'channels' => [
        'telegram' => [
            'enabled' => env('LOG_TELEGRAM_ENABLED', false),
            'token' => env('TELEGRAM_BOT_TOKEN', ''),
            'chat_id' => env('TELEGRAM_CHAT_ID', ''),
        ],
        'http' => [
            'enabled' => env('LOG_HTTP_ENABLED', false),
            'url' => env('LOG_HTTP_URL', ''),
            'method' => env('LOG_HTTP_METHOD', 'POST'),
            'headers' => [
                'Content-Type' => 'application/json',
            ],
        ],
        'sms' => [
            'enabled' => env('LOG_SMS_ENABLED', false),
            'from' => env('VONAGE_SMS_FROM', ''),
        ],
        'email' => [
            'enabled' => env('LOG_EMAIL_ENABLED', false),
            'to' => env('LOG_EMAIL_TO', ''),
            'from' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
        ],
    ],
    'default_channels' => env('LOG_DEFAULT_CHANNELS', 'email'),
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
];