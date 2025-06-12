<?php

namespace Bzilee\MultichannelLog\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Bzilee\MultichannelLog\Channels\EmailLogChannel;
use Bzilee\MultichannelLog\Channels\HttpLogChannel;
use Bzilee\MultichannelLog\Channels\SmsLogChannel;
use Bzilee\MultichannelLog\Channels\TelegramLogChannel;

class LogNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $message;
    protected $channels;

    public function __construct($message, $channels)
    {
        $this->message = $message;
        $this->channels = $channels;
        $this->onQueue('multichannel-logs');
    }

    public function via($notifiable)
    {
        return array_filter($this->channels, function ($channel) {
            return config("multichannel_log.channels.$channel.enabled", false);
        });
    }

    public function toTelegram($notifiable)
    {
        return (new TelegramLogChannel())->send($this->message);
    }

    public function toHttp($notifiable)
    {
        return (new HttpLogChannel())->send($this->message);
    }

    public function toSms($notifiable)
    {
        return (new SmsLogChannel())->send($this->message);
    }

    public function toMail($notifiable)
    {
        return (new EmailLogChannel())->send($this->message);
    }
}