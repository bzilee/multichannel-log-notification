<?php

namespace Bzilee\MultichannelLog;

use App\Notifications\LogNotification;
use Illuminate\Support\Facades\Notification;

class LogManager
{
    protected $config;

    public function __construct($app)
    {
        $this->config = $app['config']['multichannel_log'];
    }

    public function send($message, $channels = null)
    {
        $channels = $channels ?? explode(',', $this->config['default_channels']);
        $notifiable = new class {
            use \Illuminate\Notifications\Notifiable;

            public function routeNotificationForTelegram()
            {
                return config('multichannel_log.channels.telegram.chat_id');
            }

            public function routeNotificationForMail()
            {
                return config('multichannel_log.channels.email.to');
            }

            public function routeNotificationForVonage()
            {
                return config('multichannel_log.channels.sms.to');
            }
        };

        Notification::send($notifiable, new LogNotification($message, $channels));
    }
}