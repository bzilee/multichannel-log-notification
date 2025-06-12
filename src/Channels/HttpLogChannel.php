<?php

namespace Bzilee\MultichannelLog\Channels;

use GuzzleHttp\Client;

class HttpLogChannel
{
    public function send($message)
    {
        $client = new Client();
        $config = config('multichannel_log.channels.http');

        $client->request($config['method'], $config['url'], [
            'headers' => $config['headers'],
            'json' => ['message' => $message],
        ]);

        return true;
    }
}