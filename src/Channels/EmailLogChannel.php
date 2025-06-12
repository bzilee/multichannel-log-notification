<?php

namespace Bzilee\MultichannelLog\Channels;

use Illuminate\Notifications\Messages\MailMessage;

class EmailLogChannel
{
    public function send($message)
    {
        return (new MailMessage)
            ->subject('Log Notification')
            ->line($message)
            ->line('This is an automated log notification.');
    }
}