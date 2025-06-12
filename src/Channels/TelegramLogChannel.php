<?php

namespace Bzilee\MultichannelLog\Channels;

use NotificationChannels\Telegram\TelegramMessage;

class TelegramLogChannel
{
    public function send($message)
    {
        return TelegramMessage::create()->content($message);
    }
}