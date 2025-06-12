<?php

namespace Bzilee\MultichannelLog\Channels;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class TelegramLogChannel
{
    public function send($message)
    {
        $config = config('multichannel_log.channels.telegram');
        if (!$config['enabled'] || !$config['token'] || !$config['chat_id']) {
            return false;
        }

        $client = new Client();
        $url = "https://api.telegram.org/bot{$config['token']}/sendMessage";

        try {
            $response = $client->post($url, [
                'json' => [
                    'chat_id' => $config['chat_id'],
                    'text' => $message,
                    'parse_mode' => 'HTML',
                ],
            ]);

            return $response->getStatusCode() === 200;
        } catch (RequestException $e) {
            \Log::error('Failed to send Telegram log: ' . $e->getMessage());
            return false;
        }
    }
}