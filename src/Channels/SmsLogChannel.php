<?php

namespace Bzilee\MultichannelLog\Channels;

use Illuminate\Notifications\Messages\VonageMessage;

class SmsLogChannel
{
    public function send($message)
    {
        return (new VonageMessage)->content($message);
    }
}